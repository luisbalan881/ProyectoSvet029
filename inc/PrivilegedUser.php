<?php
class PrivilegedUser extends User
{
    private $roles;

    public function __construct() {
        parent::__construct();
    }

    // override User method
    public static function getByUserId($user_id) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT user_id,user_nm1,user_nm2,user_ap1,user_ap2,user_mail FROM vp_user WHERE user_id = :user_id";
        $sth = $pdo->prepare($sql);
        $sth->execute(array(":user_id" => $user_id));
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();

        if (!empty($result)) {
            $privUser = new PrivilegedUser();
            $privUser->persona['user_id'] = $result["user_id"];
            $privUser->persona['user_nm'] = $result["user_nm1"].' '.$result["user_ap1"];
            $privUser->persona['user_mail'] = $result["user_mail"];
            $privUser->initRoles();
            return $privUser;
        } else {
            return false;
        }
    }

    // populate roles with their associated permissions
    protected function initRoles() {
        $this->roles = array();
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT t1.role_id, t2.role_nm 
                FROM vp_user as t1
                JOIN vp_roles as t2 ON t1.role_id = t2.role_id
                WHERE t1.user_id = :user_id";
        $sth = $pdo->prepare($sql);
        $sth->execute(array(":user_id" => $this->persona['user_id']));

        while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $this->roles[$row["role_nm"]] = Role::getRolePerms($row["role_id"]);
        }
        Database::disconnect();
    }

    // check if user has a specific privilege
    public function hasPrivilege($perm) {
        foreach ($this->roles as $role) {
            if ($role->hasPerm($perm)) {
                return true;
            }
        }
        return false;
    }
}