<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AutoparkControllerTest extends WebTestCase
{
    /**
     * @dataProvider createBrandProvider
     */
    public function testCreateBrandAction($name)
    {
        $client = self::createClient();
        $client->request('POST', '/new-brand' ,array('name' => $name));
        
        $this->assertEquals(201,$client->getResponse()->getStatusCode());
    }
    public function createBrandProvider(){
        yield ['belaz'];
        yield ['scania'];
        yield ['daf'];
        yield ['toyota'];
        yield ['kia'];
    }
    /**
     * @dataProvider getBrandProvider
     */
    public function testGetBrandAction($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
    public function getBrandProvider(){
        
        yield ['/brands/maz'];
        yield ['/brands/volvo'];
        yield ['/brands/porshe'];
        yield ['/brands/seat'];
        yield ['/brands/renault'];
        
        
    }
    /**
     * @dataProvider updateBrandProvider
     */
    public function testUpdateBrandAction($name,$newName){
        
        $client = self::createClient();
        $client->request('PUT', '/update-brand' ,array('name' => $name, 'new_name'=>$newName));
        
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
        
        
    }
    public function updateBrandProvider(){
        yield ['belaz','kamaz'];
        yield ['scania','ural'];
        yield ['daf','paz'];
        yield ['toyota','iveco'];
        yield ['kia','hundai'];
    }
    /**
     * @dataProvider deleteBrandProvider
     */
    public function testDeleteBrandAction($url)
    {
        $client = self::createClient();
        $client->request('DELETE', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
    public function deleteBrandProvider(){
        
        yield ['/brands/maz'];
        yield ['/brands/volvo'];
        yield ['/brands/porshe'];
        yield ['/brands/seat'];
        yield ['/brands/renault'];
        
        
    }
     /**
     * @dataProvider createModelProvider
     */
    public function testCreateModelAction($brand_name,$model_name, $count)
    {
        $client = self::createClient();
        $client->request('POST', '/new-model' ,array('brand_name' => $brand_name,
            'model_name'=>$model_name, 'count'=>$count));
        $this->assertEquals(201,$client->getResponse()->getStatusCode());
    }
    public function createModelProvider(){
        yield ['kamaz','master',5];
        yield ['ural','41041',13];
        yield ['iveco','router',43];
        yield ['geely','atlas',15];
        yield ['hundai','accent',10];
    }
    /**
     * @dataProvider getModelProvider
     */
    public function testGetModelAction($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
    public function getModelProvider(){
        yield ['/brands/kamaz/models/master'];
        yield ['/brands/ural/models/41041'];
        yield ['/brands/iveco/models/router'];
        yield ['/brands/geely/models/atlas'];
        yield ['/brands/hundai/models/accent'];   
    }
    /**
     * @dataProvider updateModelProvider
     */
    public function testUpdateModelAction($url,$newName,$count){
        
        $client = self::createClient();
        $client->request('PUT', $url ,array( 'new_name'=>$newName, 'count' => $count));
        
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
        
        
    }
    public function updateModelProvider(){
        yield ['/brands/kamaz/models/master','lomaster',48];
        yield ['/brands/ural/models/41041','41042',51];
        yield ['/brands/iveco/models/router','hreneko',156546];
        yield ['/brands/geely/models/atlas','emgrand',454];
        yield ['/brands/hundai/models/accent','elantra',1]; 
    }
    
    /**
     * @dataProvider deleteModelProvider
     */
    public function testDeleteModelAction($url)
    {
        $client = self::createClient();
        $client->request('DELETE', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
    public function deleteModelProvider(){
        
        yield ['/brands/kamaz/models/lomaster'];
        yield ['/brands/ural/models/41042'];
        yield ['/brands/iveco/models/hreneko'];
        yield ['/brands/geely/models/emgrand'];
        yield ['/brands/hundai/models/elantra']; 
        
        
    }
}