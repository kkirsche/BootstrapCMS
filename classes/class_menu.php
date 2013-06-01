<?php
    require_once('class_database.php');
    class Menu
    {
        public $id;
        public $title;
        public $content;
        private $error;

        function get_menu($title)
        {
            $oDB = new Database;
            $this->error = false;

            $this->title = $title;

            //Check if there is a matching username, if there is, we don't want duplicates, so prevent them from !
            $oDB->query('SELECT content FROM menu WHERE title = :title');
            $oDB->bind(':title', $this->title);
            $menuRow = $oDB->single();

            if (isset($menuRow['content']))
            {
                return html_entity_decode($menuRow['content']);
            }
        }
    }
?>