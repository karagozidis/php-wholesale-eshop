<?php
class ModelCatalogFilter extends Model {
	public function addFilter($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_group` SET sort_order = '" . (int)$data['sort_order'] . "'");

		$filter_group_id = $this->db->getLastId();

		foreach ($data['filter_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "filter_group_description SET filter_group_id = '" . (int)$filter_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		if (isset($data['filter'])) {
			foreach ($data['filter'] as $filter) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "filter SET filter_group_id = '" . (int)$filter_group_id . "', sort_order = '" . (int)$filter['sort_order'] . "'");

				$filter_id = $this->db->getLastId();

				foreach ($filter['filter_description'] as $language_id => $filter_description) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "filter_description SET filter_id = '" . (int)$filter_id . "', language_id = '" . (int)$language_id . "', filter_group_id = '" . (int)$filter_group_id . "', name = '" . $this->db->escape($filter_description['name']) . "'");
				}
			}
		}

		return $filter_group_id;
	}

	public function editFilter($filter_group_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "filter_group` SET sort_order = '" . (int)$data['sort_order'] . "' WHERE filter_group_id = '" . (int)$filter_group_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "filter_group_description WHERE filter_group_id = '" . (int)$filter_group_id . "'");

		foreach ($data['filter_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "filter_group_description SET filter_group_id = '" . (int)$filter_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "filter WHERE filter_group_id = '" . (int)$filter_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "filter_description WHERE filter_group_id = '" . (int)$filter_group_id . "'");

		if (isset($data['filter'])) {
			foreach ($data['filter'] as $filter) {
				if ($filter['filter_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "filter SET filter_id = '" . (int)$filter['filter_id'] . "', filter_group_id = '" . (int)$filter_group_id . "', sort_order = '" . (int)$filter['sort_order'] . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "filter SET filter_group_id = '" . (int)$filter_group_id . "', sort_order = '" . (int)$filter['sort_order'] . "'");
				}

				$filter_id = $this->db->getLastId();

				foreach ($filter['filter_description'] as $language_id => $filter_description) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "filter_description SET filter_id = '" . (int)$filter_id . "', language_id = '" . (int)$language_id . "', filter_group_id = '" . (int)$filter_group_id . "', name = '" . $this->db->escape($filter_description['name']) . "'");
				}
			}
		}
	}

	public function deleteFilter($filter_group_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "filter_group` WHERE filter_group_id = '" . (int)$filter_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "filter_group_description` WHERE filter_group_id = '" . (int)$filter_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "filter` WHERE filter_group_id = '" . (int)$filter_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "filter_description` WHERE filter_group_id = '" . (int)$filter_group_id . "'");
	}

	public function getFilterGroup($filter_group_id) {
        $query = $this->db->query(
        " SELECT * ".
        " FROM `" . DB_PREFIX . "filter_group` fg ".
        " LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) ".
        " WHERE fg.filter_group_id = '" . (int)$filter_group_id . "' ".
        " AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getFilterGroups($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "filter_group` fg LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) WHERE fgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sort_data = array(
			'fgd.name',
			'fg.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY fgd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getFilterGroupDescriptions($filter_group_id) {
		$filter_group_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filter_group_description WHERE filter_group_id = '" . (int)$filter_group_id . "'");

		foreach ($query->rows as $result) {
			$filter_group_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $filter_group_data;
	}

	public function getFilter($filter_id) {
		$query = $this->db->query("SELECT *, (SELECT name FROM " . DB_PREFIX . "filter_group_description fgd WHERE f.filter_group_id = fgd.filter_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id = '" . (int)$filter_id . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getFilters($data) {
		$sql = "SELECT *, (SELECT name FROM " . DB_PREFIX . "filter_group_description fgd WHERE f.filter_group_id = fgd.filter_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND fd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " ORDER BY f.sort_order ASC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getFilterDescriptions($filter_group_id) {
		$filter_data = array();

		$filter_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filter WHERE filter_group_id = '" . (int)$filter_group_id . "'");

		foreach ($filter_query->rows as $filter) {
			$filter_description_data = array();

			$filter_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filter_description WHERE filter_id = '" . (int)$filter['filter_id'] . "'");

			foreach ($filter_description_query->rows as $filter_description) {
                $filter_description_data[$filter_description['language_id']] = array('name' => $filter_description['name']);
			}

			$filter_data[] = array(
				'filter_id'          => $filter['filter_id'],
				'filter_description' => $filter_description_data,
                'sort_order'         => $filter['sort_order'],
                'colorhex'         => $filter['colorhex'],
                'gencolor'         => $filter['gencolor']
			);
		}

		return $filter_data;
	}

	public function getTotalFilterGroups() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "filter_group`");

		return $query->row['total'];
    }
    

	public function getFilterGroupsOrderBy() {
		
        $sql =
        " SELECT ".
        "   fg.filter_group_id,        ".
        "   f.filter_id,               ".
        "   fgd.name as filterGroupName,    ".
        "   fd.name as filterName           ".
        " FROM `" . DB_PREFIX . "filter` f             ".
        " inner join `" . DB_PREFIX . "filter_description` fd on f.filter_id = fd.filter_id and fd.language_id = 2      ".
        " inner join `" . DB_PREFIX . "filter_group` fg on f.filter_group_id = fg.filter_group_id                       ".
        " inner join `" . DB_PREFIX . "filter_group_description` fgd on fg.filter_group_id = fgd.filter_group_id and fgd.language_id = 2     ".
        " WHERE fg.filter_group_id in (5,7,8)     ".
		" ORDER BY fgd.name,fd.name ";
  
	//	echo $sql;
		$query = $this->db->query($sql);

		return $query->rows;
    }
    

	public function getTotalFilterGroupsOrderBy() {
		$query = $this->db->query(
            " SELECT COUNT(*) AS total".
            " FROM `" . DB_PREFIX . "filter` f             ".
            " inner join `" . DB_PREFIX . "filter_description` fd on f.filter_id = fd.filter_id and fd.language_id = 2      ".
            " inner join `" . DB_PREFIX . "filter_group` fg on f.filter_group_id = fg.filter_group_id                       ".
            " inner join `" . DB_PREFIX . "filter_group_description` fgd on fg.filter_group_id = fgd.filter_group_id and fgd.language_id = 2     ".
            " WHERE fg.filter_group_id in (2,7,8)     "        
        );

		return $query->row['total'];
    }
    

	public function getFilterOrderBy($filter_id) {
		$filter_data = array();

        $sql = 
        " SELECT                              																				   " .

        " pf.filter_id,                                                                                                        " .
        " pf.product_id,                                                                                                       " .
        " fd.name as filterName,                                                                                               " .
        " p.sku,                                                                                                               " .
        " pd.name,                                                                                                             " .
        " pf.sort_order                                                                                                        " .

        " FROM `avepf_product_filter` pf                                                                                       " .
        " inner join `avepf_product` p on p.product_id = pf.product_id                                                         " .
        " inner join `avepf_product_description` pd on p.product_id = pd.product_id and pd.language_id = 2                     " .
        " inner join `avepf_filter` f on f.filter_id = pf.filter_id                                                            " .
        " inner join `avepf_filter_description` fd on f.filter_id = fd.filter_id and fd.language_id = 2                        " .
        " inner join `avepf_filter_group` fg on f.filter_group_id = fg.filter_group_id                                         " .
        " inner join `avepf_filter_group_description` fgd on fg.filter_group_id = fgd.filter_group_id and fgd.language_id = 2  " .

        " WHERE  pf.filter_id = " . (int)$filter_id . "                                                                        " .

        " order by pf.sort_order                                                                                               " ;


		$filter_query = $this->db->query($sql);

		foreach ($filter_query->rows as $filter) {
			$filter_description_data = array();

			$filter_data[] = array(
                'filter_id'          => $filter['filter_id'],
                'product_id'         => $filter['product_id'],
				'filterName'         =>  $filter['filterName'],
                'productCode'        => $filter['sku'],
                'productName'        => $filter['name'],
                'sort_order'         => $filter['sort_order']
			);
		}

		return $filter_data;
    }


	public function editFilterOrderBy($filter_id, $data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE filter_id = '" . (int)$filter_id . "'");
	
			foreach ($data['filter']  as $filter) {
				
				$sql =  " INSERT INTO " . DB_PREFIX . "product_filter  (filter_id, product_id, sort_order) ".
                        " SELECT * FROM (SELECT  '" . (int)$filter_id . "' as filter_id, ".
                        " '" . (int)$filter['product_id']   . "' as product_id, ".
                        " '" . (int)$filter['sort_order']   . "' as sort_order ) AS tmp ".
				     	" WHERE NOT EXISTS ( ".
				    	" SELECT * FROM " . DB_PREFIX . "product_filter WHERE product_id ='" . (int)$filter['product_id']   . "' AND filter_id =  '" . (int)$filter_id . "'  ".
				        " ) ";
				
				echo 
				$this->db->query($sql);
			}
	} 
	

}
