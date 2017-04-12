<?
require_once('config/config.php');

class Signer {
	// --- MARK: Singleton
	private static $instance;

	public static function getInstance() {
		if (!self::$instance) self::$instance = new Signer();
		return self::$instance;
	}

	// --- MARK: properties
	private $version = '1.0.0';

	protected $dbc;

	// --- MARK: methods
	public function __construct() {
		global $servername; // FIXME: need refactoring here
		global $username;
		global $password;
		global $dbname;

		// constructor
		try {
			$this->dbc = new PDO("mysql:host=${servername};port=3306;dbname=${dbname};charset=utf8", $username, $password);
		} catch (PDOException $e) {
			print "データベース接続失敗: ".$e->getMessage()."<br />";
			die();
		}
	}

	/**
	 * Add a new user
	 * @param $name: user's name
	 * @return id
	 */
	public function addUser($name) {
		if (empty($name)) {
			throw new InvalidArgumentException("\$name is invalid: ${name}");
		}
		$stmt = $this->dbc->prepare("insert into `users` (name) values (:name) on duplicate key update name=:name");
		$stmt->bindParam(':name', $name, PDO::PARAM_STR);
		$stmt->execute();
		return $this->dbc->lastInsertId();
	}

	/**
	 * Returns users
	 * @return array of users
	 */
	public function getUsers() {
		$stmt = $this->dbc->prepare("select * from `users`");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Deletes a user
	 * @param $id: user's id
	 */
	public function deleteUser($id) {
		$stmt = $this->dbc->prepare("delete from `users` where id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	 * Returns logs joined with users
	 * @return array of logs
	 */
	public function getLogs() {
		$stmt = $this->dbc->prepare("select * from `logs` natural join `users`");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Performs login action
	 * @param $userId user's id
	 * @return id
	 */
	public function login($userId) {
		if (empty($userId) || $userId < 0) {
			throw new InvalidArgumentException("\$userId is invalid: ${userId}");
		}

		// select
		$stmt = $this->dbc->prepare("select id from `users` where id=:id");
		$stmt->bindParam(':id', $userId, PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->fetchColumn() === FALSE) {
			throw new InvalidArgumentException('No user record found for ${userId}');
		}

		// insert
		$stmt = $this->dbc->prepare("insert into `logs` (user_id, type) values (:user_id, :type)");
		$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
		$stmt->bindValue(':type', 'in', PDO::PARAM_STR);
		$stmt->execute();

		return $this->dbc->lastInsertId();
	}

	/**
	 * Performs logout action
	 * @param $userId user's id
	 * @return id
	 */
	public function logout($userId) {
		if (empty($userId) || $userId < 0) {
			throw new InvalidArgumentException("\$userId is invalid: ${userId}");
		}

		// select
		$stmt = $this->dbc->prepare("select id from `users` where id=:id");
		$stmt->bindParam(':id', $userId, PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->fetchColumn() === FALSE) {
			throw new InvalidArgumentException('No user record found for ${userId}');
		}

		// insert
		$stmt = $this->dbc->prepare("insert into `logs` (user_id, type) values (:user_id, :type)");
		$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
		$stmt->bindValue(':type', 'out', PDO::PARAM_STR);
		$stmt->execute();
		
		return $this->dbc->lastInsertId();
	}
}