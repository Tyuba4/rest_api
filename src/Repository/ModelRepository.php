<?php

namespace App\Repository;

use App\Entity\Model;
//use App\Entity\Brand;
use App\Repository\BrandRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Model|null find($id, $lockMode = null, $lockVersion = null)
 * @method Model|null findOneBy(array $criteria, array $orderBy = null)
 * @method Model[]    findAll()
 * @method Model[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Model::class);
    }
    
    public function createNewModel($request,$doctrine){
        
        $brand = BrandRepository::getBrandRepositoryByName($request->get('brand_name'), $doctrine);
        if (!$brand) {
            throw new NotFoundHttpException(
                'Brand not found'
            );
        }
        $model = new Model();
        $model->setName($request->get('model_name'));
        $model->setCount($request->get('count'));

        // relates this model to the brand
        $model->setBrand($brand);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($brand);
        $entityManager->persist($model);
        $entityManager->flush();
    }
    
    public function getModel($brand_name, $model_name, $doctrine){
        $brand = BrandRepository::getBrandRepositoryByName($brand_name, $doctrine);
        if (!$brand) {
            throw new NotFoundHttpException(
                'Brand not found'
            );
        }
        $models = $brand->getModels();
        foreach ($models as $modelOne){
            if($modelOne->getName() == $model_name){
                $model = $modelOne;
                break;
                
            }
        }
        
        if(!isset($model)){
            throw new NotFoundHttpException(
                'Model not found'
            );
            
        }
        return $model;
    }
    
    public function updateModel($brand_name, $model_name, $doctrine, $request){
        $brand = BrandRepository::getBrandRepositoryByName($brand_name, $doctrine);
        if (!$brand) {
            throw new NotFoundHttpException(
                'Brand not found'
            );
        }
        $entityManager = $doctrine->getManager();
        $models = $brand->getModels();
        foreach ($models as $modelOne){
            if($modelOne->getName() == $model_name){
                $found = 1;
                if($request->get('new_name')){
                    $modelOne->setName($request->get('new_name'));
                }
                if($request->get('count')){
                    $modelOne->setCount($request->get('count'));
                }
                $entityManager->flush();
                break;  
            }
        }
         if(!isset($found)){
            throw new NotFoundHttpException(
                'Model not found'
            );
        }
    }
    public function deleteModel($brand_name, $model_name, $doctrine) {
        $brand = BrandRepository::getBrandRepositoryByName($brand_name, $doctrine);
        if (!$brand) {
            throw new NotFoundHttpException(
                'Brand not found'
            );
        }
        $models = $brand->getModels();
        $sn = $doctrine->getManager();
        foreach ($models as $modelOne){
            
            if($modelOne->getName() == $model_name){
                $found = 1;
                $sn->remove($modelOne);
                $sn->flush();
            }
            
        }
        if(!isset($found)){
            throw new NotFoundHttpException(
                'Model not found'
            );
        }
        
    }
    
    
    

//    /**
//     * @return Model[] Returns an array of Model objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Model
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
