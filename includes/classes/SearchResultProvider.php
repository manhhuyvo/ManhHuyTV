<?php

class SearchResultProvider {
    private $conn, $username;

    public function __construct($con, $username){
        $this -> conn = $con;
        $this -> username = $username;
    }

    public function getSearchResult($searchValue){
        $entities = EntityProvider::getSearchEntities($this->conn, $searchValue, 30);
        $html = "<div class='preview-categories no-scroll'>";
        $html.= $this->getSearchResultHTML($entities);
        
        return $html . "</div>";
    }

    private function getSearchResultHTML($entities) {

        // This if statement is to prevent showing the category that has no movies in it
        if (sizeof($entities) == 0){
            return ;
        }

        $entitiesHTML = "";

        $previewProvider = new PreviewProvider($this->conn, $this->username);

        foreach ($entities as $entity){
            $entitiesHTML = $entitiesHTML . $previewProvider->createEntityPreviewSquare($entity);
        }

        //Return the category name in the link and list of entities insde the div
        return "<div class='category'>
                    <div class='entities'>".$entitiesHTML."
                    </div>
                </div>";
    }
}
?>