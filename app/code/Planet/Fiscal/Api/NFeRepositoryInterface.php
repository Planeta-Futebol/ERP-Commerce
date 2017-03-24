<?php
namespace Planet\Fiscal\Api;

use Planet\Fiscal\Model\NFeInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface NFeRepositoryInterface 
{
    public function save(NFeInterface $page);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(NFeInterface $page);

    public function deleteById($id);
}
