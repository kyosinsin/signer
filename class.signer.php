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
	 * Returns users
	 */
	public function getUsers() {
		$stmt = $this->dbc->prepare("select * from `users`");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Returns logs joined with users
	 */
	public function getLogs() {
		$stmt = $this->dbc->prepare("select * from `logs` natural join `users`");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}