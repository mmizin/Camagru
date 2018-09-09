<?php
class View {

	public function render($contentView, $templateView, $data = null) {

		if (is_array($data)) {
			extract($data);
		}
		include ROOT . '/view/' . $templateView . '.php';
	}
}