<?php
abstract class main {
    protected $connection;
    private   $dbc;
    protected $SKU;
    protected $Name;
    protected $Price;
    protected $measurements;


    public function __construct(){

//        $this->connection = new mysqli('localhost','root','','product');
    $this->dbc = new PDO("mysql:host=localhost;dbname=product","root","");
    }

    public function addProduct(){
            $SKU = $this->getSKU();
            $name = $this->getName();
            $price = $this->getPrice();
            $measurements = $this->getMeasurements();
//        $this->connection->query("INSERT INTO `products`(`SKU`, `Name`, `Price`, `Measurements`) VALUES ('$SKU','$name','$price','$measurements')");
            $stmt = $this->dbc->prepare("INSERT INTO `products`(`SKU`, `Name`, `Price`, `Measurements`) VALUES (:SKU,:name,:price,:measurements)");

            $stmt->bindParam('SKU',$SKU);
            $stmt->bindParam('name',$name);
            $stmt->bindParam('price',$price);
            $stmt->bindParam('measurements',$measurements);

            $stmt->execute();
    }

    public function setSKU($SKU){
        $this->SKU=$SKU;
    }
    public function setName($Name){
        $this->Name=$Name;
    }
    public function setPrice($Price){
        $this->Price=$Price;
    }

    abstract public function setMeasurements();

    public function getSKU(){
        return $this->SKU;
    }
    public function getName(){
        return $this->Name;
    }
    public function getPrice(){
        return $this->Price;
    }
    public function getMeasurements(){
        return $this->measurements  ;
    }

//    public function getProducts(){
//        $result = $this->connection->query("SELECT * FROM `products`");
//
//        if($result->num_rows>0){
//            $products = array();
//            while($row = $result->fetch_assoc()){
//                $products[] = $row;
//            }
////            print_r($products);
//            return $products;
//        }
//    }
//
//    public function deleteProducts($id){
//
//        $this->connection->query("DELETE FROM `products` WHERE `id`=$id");
//
//    }

    public function __deconstruct(){
//        $this->connection->close();
        $this->dbc= null;

    }


}


class dvd extends main{
    public function productType(){
//        $size = $size = $_POST['size'];
        return '<form>
            <label for="size">Size (MB)</label>
            <input id="size" type="number" name="size" min="0" required oninvalid="this.setCustomValidity(`Please, submit required data`)" oninput="this.setCustomValidity(``)"/>

        </form> '."</br>"."Please, provide size in MB";
    }

//    public function setDescription(){
//        $description = 'Size: '.$_POST['size'].' MB';
//        $this->setMeasurements($description);
//
//    }
    public function setMeasurements(){
        $description = 'Size: '.$_POST['size'].' MB';
        $this->measurements = $description;
    }


//    public function addType(){
//        if(!empty($measurements)) $measurements= "Size: ".$_POST['size']." MB ";
//    }
}



class book extends main{
    public function productType(){
//        $weight = $_POST['weight'];
//        $measurements = "Weight: ".$_POST['weight']." KG ";
        return '<form>
            <label for="weight">Weight (KG)</label>
            <input id="weight" type="number" name="weight" min="0" required oninvalid="this.setCustomValidity(`Please, submit required data`)" oninput="this.setCustomValidity(``)"/>

        </form>'."</br>"."Please, provide weight in KG";
    }
//    public function setDescription(){
//        $description = 'Weight: '.$_POST['weight'].' KG';
//        $this->setMeasurements($description);
//
//    }
    public function setMeasurements(){
        $description = 'Weight: '.$_POST['weight'].' KG';
        $this->measurements = $description;
    }
}

class furniture extends main{
    public function productType(){
//        $height = $_POST['height'];
//        $width = $_POST['width'];
//        $length = $_POST['length'];


//        $measurements = "Dimensions: ".$height."x".$width."x".$length;

        return '<form>
            <label for="height">Height (CM)</label>
            <input id="height" type="number" name="height" min="0" required oninvalid="this.setCustomValidity(`Please, submit required data`)" oninput="this.setCustomValidity(``)"/><br />
            <label for="width">Width (CM)</label>
            <input id="width" type="number" name="width"  min="0" required oninvalid="this.setCustomValidity(`Please, submit required data`)" oninput="this.setCustomValidity(``)" /><br />
            <label for="length">Length (CM)</label>
            <input id="length" type="number" name="length" min="0" required oninvalid="this.setCustomValidity(`Please, submit required data`)" oninput="this.setCustomValidity(``)" /><br />

        </form>'."</br>"."Please, provide dimensions in CM";
    }

//    public function setDescription(){
//        $description = 'Dimension: '.$_POST['height'].'x'.$_POST['width'].'x'.$_POST['length'];
//        $this->setMeasurements($description);
//
//    }
    public function setMeasurements(){
        $description = 'Dimension: '.$_POST['height'].'x'.$_POST['width'].'x'.$_POST['length'];
        $this->measurements = $description;
    }
}

class products{
//    protected $connection;
      protected $dbc;
      private $id;
      private $SKU;
      private $Name;
      private $Price;

    public function __construct(){

//        $this->connection = new mysqli('localhost','root','','product');
          $this->dbc = new PDO("mysql:host=localhost;dbname=product","root","");
    }



    public function getProducts(){
//        $result = $this->connection->query("SELECT * FROM `products`");
//        if($result->num_rows>0){
//            $products = array();
//            while($row = $result->fetch_assoc()){
//                $products[] = $row;
//            }
////            print_r($products);
//            return $products;
//        }

        $result = $this->dbc->query("SELECT * FROM `products`");
        $result->setFetchMode(PDO::FETCH_CLASS,"products");
        $result->execute();

        $products = array();
        while($row = $result->fetch()){
            $products[] = $row;
        }
//        echo '<pre>';
//        print_r($products);
        return $products;

    }

    public function getId(){
        return $this->id;
    }
    public function getSKU(){
        return $this->SKU;
    }
    public function getName(){
        return $this->Name;
    }
    public function getPrice(){
        return $this->Price;
    }




    public function deleteProducts($id){

//        $this->connection->query("DELETE FROM `products` WHERE `id`=$id");
        $stmt = $this->dbc->prepare("DELETE FROM `products` WHERE `id`=:id");
        $stmt->bindParam('id',$id);
        $stmt->execute();

    }

    public function __deconstruct(){
        $this->connection->close();
    }
}

    if(isset($_POST['Type_Switcher'])) {
        $class = new $_POST['Type_Switcher']();
        echo $class->productType();

    }
    if(isset($_POST['SKU'])){
        $product = new $_POST['select']();
    //        probably delete
//        $SKU = $_POST['SKU'];
//        $name = $_POST['name'];
//        $price = $_POST['price'];
        $product->setSKU($_POST['SKU']);
        $product->setName($_POST['name']);
        $product->setPrice($_POST['price']);
        $product->setMeasurements();
        $product->addProduct();
        ?>
        <Script>
            window.location='productlist.php';
        </Script>
    <?php
    }


//$id = $product['id'];
//$sku = $product['SKU'];
//$name = $product['Name'];
//$price = $product['Price'];
//$description = $product['Measurements'];