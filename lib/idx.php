<?php

function idx(array $a, $k, $d = null) {
	if (array_key_exists($k, $a)) {
		return $a[$k];
	} else {
		return $d;
	}
}
