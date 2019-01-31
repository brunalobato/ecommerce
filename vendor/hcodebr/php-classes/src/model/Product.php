<?php

namespace Hcode\model;

use \Hcode\DB\Sql;
use \Hcode\model;
use \Hcode\Mailer;

class Product extends model {

    public static function listAll()
    {
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_products ORDER BY desproduct");

    }

    public static function checkList($list)
    {
        foreach ($list as &$row) {
            $p = new Product();
            $p->setData($row);
            $row = $p->getValues();
        }

        return $list;
    }

    public function save()
    {

        $sql = new Sql();

        $results = $sql->select("CALL sp_products_save(:idproduct, :desproduct, :vlprice, :vlwidth, :vlheight, :vllenght, :vlweight, :desurl)", array(
              
              ":idproduct"=>$this->getidproduct(),
              ":desproduct"=>$this->getdesproduct(),
              ":vlprice"=>$this->getvlprice(),
              ":vlwidth"=>$this->getvlwidth(),
              ":vlheight"=>$this->getvlheight(),
              ":vllenght"=>$this->getvllenght(),
              ":vlweight"=>$this->getvlweight(),
              ":desurl"=>$this->getdesurl()
  
          ));
  
          $this->setData($results[0]);

        }

        public function get($idproduct)
        {
            $sql = new Sql();

           $results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct", [

                ':idproduct'=>$idproduct
            ]);

            $this->setData($results[0]);
        }

        public function delete()
        {
            $sql = new Sql();

            $sql->query("DELETE FROM tb_products WHERE idproduct = :idproduct", [

                ':idproduct'=>$this->getidproduct()
            ]);

            }

            public function checkPhoto()
            {
                if(file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "res". DIRECTORY_SEPARATOR . "site" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . $this->getidproduct() . "jpg")){

                    $url = "/res/site/img/products/" . $this->getproduct() . "jpg";

                } else {

                    $url = "/res/site/img/product.jpg";
                }

                return $this->setdesphoto($url);
            }

            public function getValues()
            {

                $this->checkPhoto();

                $values = parent::getValues();

                return $values;
            }

            public function setPhoto($file)
            {
                $extensions = explode('.', $file['name']);
                $extensions = end($extensions);

                switch ($extensions) {

                    case "jpg":
                    case "jpeg":

                    $image = imagecreatefromjpeg(["tmp_name"]);
                    break;

                    case "gif":
                    $image = imagecreatefromgif(["tmp_name"]);
                    break;

                    case "png":
                    $image = imagecreatefrompng(["tmp_name"]);
                    break;
                }

                $dist = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "res". DIRECTORY_SEPARATOR . "site" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . $this->getidproduct() . "jpg";

                imagejpeg($image, $dist);   
                imagedestroy($image);

                $this->checkPhoto();
            }

            public function getFromURL($desurl)
            {
                $sql = new Sql();

                $row = $sql->select("SELECT * FROM tb_products WHERE desurl = : desurl", [

                    ':desurl'=>$desurl
                ]);

                $this->setData($rows[0]);
            }

            public function getCategories()
            {
                $sql = new Sql();
                 return $sql->select("SELECT * FROM
                 tb_categories a INNER JOIN tb_productscategories b ON a.idcategory = b.idcategory WHERE b.idproduct =
                    :idproduct
                ",[
                    
                    ':idproduct'=>$this->getidproduct()
                 
                ]);
            }
        }

?>