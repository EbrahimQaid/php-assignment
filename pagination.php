<?php
// pagination.php
class Pagination {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getUsers($search = '', $page = 1) {
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT id, name, email FROM users";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " WHERE name LIKE ?";
            $params[] = "%$search%";
        }
        
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll();
    }
    
    public function getTotal($search = '') {
        $sql = "SELECT COUNT(*) FROM users";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " WHERE name LIKE ?";
            $params[] = "%$search%";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchColumn();
    }
}

// الاستخدام
$pdo = new PDO("mysql:host=localhost;dbname=test", "root", "");
$pagination = new Pagination($pdo);

$users = $pagination->getUsers('محمد', 1);
$total = $pagination->getTotal('محمد');
?>
