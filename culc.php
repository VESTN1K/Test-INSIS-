<?php
	class SumBigInt
	{
		private $length;
		
		public function __construct () {
			$this->length = strlen((string)PHP_INT_MAX) - 1;
		}

		private function normalise ($str) {
			$r = $this->length - strlen($str) % $this->length;
			for ($i = 0; $i < $r; $i++)
				$str = '0'.$str;
			return $str;
		}

		private function convert ($str) {
			return str_split($str, $this->length);
		}

		public function sum ($val1, $val2) {
			$result = [];
			$resp = '';
			$arr1 = $this->convert($this->normalise($val1));
			$arr2 = $this->convert($this->normalise($val2));

			$maxLength = (count($arr1) >= count($arr2) ? count($arr1) : count($arr2));
			$add = 0;
			for ($i = 0; $i < $maxLength; $i++) {
				$temp;
				if (isset($arr1[count($arr1) - 1 - $i]) && isset($arr2[count($arr2) - 1 - $i])) {
					$temp = (int)$arr1[count($arr1) - 1 - $i] + (int)$arr2[count($arr2) - 1 - $i];
					if ($add) {
						$temp += $add;
						$add = 0;
					}
					if (strlen((string)$temp) > $this->length) {
						$add = (int)substr((string)$temp, 0, 1);
						$temp = (int)substr((string)$temp, -1 * $this->length);
					}
				}
				else {
					$temp = (isset($arr1[count($arr1) - 1 - $i]) ? (int)$arr1[count($arr1) - 1 - $i] : (int)$arr2[count($arr2) - 1 - $i]);
					if ($add) {
						$temp += $add;
						$add = 0;
					}
				}
				$result[] = $temp;
			}
			if ($add)
				$result[] = $add;

			for ($i = count($result) - 1; $i > -1; $i--)
				$resp = $resp.(string)$result[$i];
			return $resp;
		}
	}
?>