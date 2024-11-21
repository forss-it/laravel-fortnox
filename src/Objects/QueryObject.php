<?php

namespace Warbio\Fortnox\Objects;

use Warbio\Fortnox\Exceptions\FortnoxException;

class QueryObject
{
    protected $search = [];
    protected $filter = null;
    protected $sortBy = null;
    protected $sortOrder = null;
    protected $limit = null;
    protected $offset = null;
    protected $page = null;

    /**
     * Returns an array representation of the object.
     *
     * @return array
     */
    public function toArray()
    {
        $query = [
            'filter'    => $this->getFilter(),
            'sortby'    => $this->getSortBy(),
            'sortorder' => $this->getSortOrder(),
            'limit'     => $this->getLimit(),
            'offset'    => $this->getOffset(),
            'page'      => $this->getPage(),
        ];

        $query = array_filter(
            array_merge($query, $this->getSearch())
        );

        $query = array_map('mb_strtolower', $query);

        return $query;
    }

    /**
     * @return mixed
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return self
     */
    public function setSearch(string $key, string $value)
    {
        $this->search[$key] = $search;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param string $filter
     *
     * @return self
     */
    public function setFilter(string $filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }

    /**
     * @param string $sortBy
     *
     * @return self
     */
    public function setSortBy(string $sortBy)
    {
        $this->sortBy = $sortBy;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param string $sortOrder
     *
     * @return self
     */
    public function setSortOrder(string $sortOrder)
    {
        if (in_array($sortOrder, ['ascending', 'descending'])) {
            throw new FortnoxException('Sort order must be ascending or descending.');
        }

        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * @return self
     */
    public function sortAsc()
    {
        $this->sortOrder = 'ascending';

        return $this;
    }

    /**
     * @return self
     */
    public function sortDesc()
    {
        $this->sortOrder = 'descending';

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @return self
     */
    public function setLimit(int $limit)
    {
        if ($limit > 500) {
            throw new FortnoxException('Limit can not be higher then 500.');
        }

        $this->limit = $limit;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     *
     * @return self
     */
    public function setOffset(int $offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     *
     * @return self
     */
    public function setPage(int $page)
    {
        $this->page = $page;

        return $this;
    }
}
