<?php

namespace App\Controller;

use App\Entity\Brand as Brand;
use App\Entity\Model;
//use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;


class AutoparkController extends FOSRestController
{
    
     /**
     * Create Brand.
     * @FOSRest\Post("/new-brand")
     *
     * @return array
     */

    
    public function createNewBrandAction(Request $request)
    {
        
        $this->getDoctrine()->getRepository(Brand::class)
                ->createNewBrand($request,$this->getDoctrine());
        return View::create('Brand succesfully created', Response::HTTP_CREATED , []);
        
    }
    /**
     * Get Brand.
     * @FOSRest\Get("/brands/{name}")
     */
    public function getBrandAction($name)
    {
        $brand = $this->getDoctrine()->getRepository(Brand::class)
                ->findOneBy(['name'=>$name]);
        return View::create($brand, Response::HTTP_OK, []);
        
    }
    /**
     * Update Brand.
     * @FOSRest\Put("/update-brand")
     */
    public function updateBrandAction(Request $request){
        
        
        $this->getDoctrine()->getRepository(Brand::class)
                ->updateBrand($request,$this->getDoctrine());
        return View::create('Updated!', Response::HTTP_OK, []);
    
        
    }
    /**
     * Delete Brand.
     * @FOSRest\Delete("/brands/{name}")
     */
    
    public function deleteBrandAction($name)
    {
        
        $this->getDoctrine()->getRepository(Brand::class)
                ->deleteBrand($name,$this->getDoctrine());
        return View::create('deleted successfully!', Response::HTTP_OK, []);
    }

    
    
    
     /**
     * Create Model.
     * @FOSRest\Post("/new-model")
     */
    public function createNewModelAction(Request $request)
    {
        
        $this->getDoctrine()->getRepository(Model::class)
                ->createNewModel($request,$this->getDoctrine());
        return View::create('Model succesfully created', Response::HTTP_CREATED , []);
        
    }
    /**
     * Get Model.
     * @FOSRest\Get("/brands/{brand_name}/models/{model_name}")
     */
    public function getModelAction($brand_name, $model_name)
    {
        
        $model = $this->getDoctrine()->getRepository(Model::class)
                ->getModel($brand_name, $model_name,$this->getDoctrine());
        return View::create($model, Response::HTTP_OK, []);
        
        
        
    }
    
    
    /**
     * Update Model.
     * @FOSRest\Put("/brands/{brand_name}/models/{model_name}")
     */
    public function updateModelAction($brand_name, $model_name, Request $request)
    {
        $this->getDoctrine()->getRepository(Model::class)
                ->updateModel($brand_name, $model_name,$this->getDoctrine(), $request);
        return View::create('Model updated', Response::HTTP_OK, []);
    }
    /**
     * Delete Model.
     * @FOSRest\Delete("/brands/{brand_name}/models/{model_name}")
     */
    public function deleteModelAction($brand_name, $model_name){
        
        $this->getDoctrine()->getRepository(Model::class)
                ->deleteModel($brand_name, $model_name,$this->getDoctrine());
        return View::create('Model deleted', Response::HTTP_OK, []);
    }
    
}
