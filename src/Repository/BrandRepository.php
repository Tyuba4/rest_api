<?php

namespace App\Repository;

use App\Entity\Brand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Brand|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brand|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brand[]    findAll()
 * @method Brand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrandRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Brand::class);
    }
    
    public function createNewBrand($request, $doctrine){
        
        $brand = new Brand();
        $brand->setName($request->get('name'));
        $em = $doctrine->getManager();
        $em->persist($brand);
        $em->flush();
        
        
    }
    public function findOneByName($name,$doctrine){
        $brand = BrandRepository::getBrandRepositoryByName($name, $doctrine);
        if (!$brand) {
            throw new NotFoundHttpException(
                'Brand not found!'
            );
        }
        return $brand;
    }
    public function updateBrand($request, $doctrine){
        
        $entityManager = $doctrine->getManager();
        $brand = BrandRepository::getBrandRepositoryByName($request->get('name'), $doctrine);
        if (!$brand) {
            throw new NotFoundHttpException(
                'No brand found for name '.$request->get('name')
            );
        }
        $brand->setName($request->get('new_name'));
        $entityManager->flush();
        
        
    }
    
    public function deleteBrand($name,$doctrine){
        
        $sn = $doctrine->getManager();
        $brand = self::getBrandRepositoryByName($name, $doctrine);
        if (!$brand) {
            throw new NotFoundHttpException(
                'Brand not found!'
            );
        }
        else {
            self::deleteModelsByBrand($brand,$doctrine->getManager());
            $sn->remove($brand);
            $sn->flush();  
        }
    }
    
    static private function getBrandRepositoryByName($name, $doctrine){
        $brand = $doctrine->getRepository(Brand::class)
                ->findOneBy(['name' => $name] );
        return $brand;   
    }
    static public function getPublicBrandRepositoryByName($name, $doctrine){
        return self::getBrandRepositoryByName($name, $doctrine);
        
    }


    static private function deleteModelsByBrand($brand,$sn){
        $models = self::getModelsByBrand($brand);
        foreach($models as $model){
            $sn->remove($model);
            $sn->flush();
        }
        
    }

    static private function getModelsByBrand($brand){
        $models = $brand->getModels();
        return $models;
        
    }
//    /**
//     * @return Brand[] Returns an array of Brand objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Brand
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
