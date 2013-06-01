<?php
    require_once('class_database.php');
    class Page
    {
        public $id;
        public $title;
        public $content;

        function get_page($id)
        {
            $oDB = new Database;

            $this->id = $id;

            //Check if there is a matching username, if there is, we don't want duplicates, so prevent them from !
            $oDB->query('SELECT content FROM pages WHERE id = :id');
            $oDB->bind(':id', $this->id);
            $pageRow = $oDB->single();

            if (isset($pageRow['content']))
            {
                return html_entity_decode($pageRow['content']);
            }
            else
            {

                return "Error 404.";
            }
        }

        function get_admin_page($id)
        {
            $oDB = new Database;

            $this->id = $id;

            //Check if there is a matching username, if there is, we don't want duplicates, so prevent them from !
            $oDB->query('SELECT content FROM admin WHERE id = :id');
            $oDB->bind(':id', $this->id);
            $pageRow = $oDB->single();

            if (isset($pageRow['content']))
            {
                return html_entity_decode($pageRow['content']);
            }
            else
            {

                return "Error 404.";
            }
        }

        function insert_page($title, $content)
        {
            $oDB = new Database;

            $this->title = htmlentities($title);
            $this->content = htmlentities($content);

            //Begin the transaction
            $oDB->beginTransaction();
            //Prep the statement to put these into our database.
            $oDB->query("INSERT into pages (title, content) VALUES (:title, :content)");
            //Bind the data we want
            $oDB->bind(':title', $this->title);
            $oDB->bind(':content', $this->content);
            //Execute the statement
            $oDB->execute();
            //End the transaction
            $oDB->endTransaction();
        }
    }
?>