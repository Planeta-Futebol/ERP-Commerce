<?php
/**
 * Copyright © 2017 Planeta Core Team. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Planet\Fiscal\Api;

use Planet\Fiscal\Model\NFeInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface for NFe.
 *
 * @api
 */
interface NFeRepositoryInterface 
{
    /**
     * @param NFeInterface $page
     * @return mixed
     */
    public function save(NFeInterface $page);

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param SearchCriteriaInterface $criteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $criteria);

    /**
     * @param NFeInterface $page
     * @return mixed
     */
    public function delete(NFeInterface $page);

    /**
     * @param $id
     * @return mixed
     */
    public function deleteById($id);
}
