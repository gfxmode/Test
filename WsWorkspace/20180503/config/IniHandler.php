<?php
    class IniHandler {
        private $ini_array;
        public function __construct($in_file_path) {
            $this->ini_array = parse_ini_file($in_file_path, true);
        }

        // 获取Global字段的配置值
        public function getGlobalKey($in_key) {
            return $this->ini_array['Global'][$in_key];
        }
    }
?>