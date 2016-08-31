<?php
namespace Planet\Agent\Api;

use Planet\Agent\Model\ImportInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ImportRepositoryInterface 
{
    public function save(ImportInterface $page);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(ImportInterface $page);

    public function deleteById($id);
}
