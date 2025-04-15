<?php
require 'vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class DataBroadcaster implements MessageComponentInterface {
    protected $clients;
    
    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->startFetchLoop();
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        // Nếu cần xử lý tin nhắn từ client (VD: addEmployee)
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }

    public function startFetchLoop() {
        $loop = React\EventLoop\Factory::create();

        $loop->addPeriodicTimer(10, function () {
            $data = $this->fetchAndMerge();
            foreach ($this->clients as $client) {
                $client->send(json_encode($data));
            }
        });

        $loop->run();
    }

    public function fetchAndMerge() {
        $url1 = "http://localhost:19335/api/personals";
        $url2 =  "http://localhost:8000/api/employees";

        $dataset1 = json_decode(file_get_contents($url1), true) ?? [];
        $dataset2 = json_decode(file_get_contents($url2), true) ?? [];

        $merged_data = [];
        $matched_ids = [];

        foreach ($dataset1 as $emp1) {
            $matched = false;
            foreach ($dataset2 as $emp2) {
                if (
                    $emp1['Employee_ID'] == (int)$emp2['idEmployee'] &&
                    $emp1['Last_Name'] == $emp2['lastName'] &&
                    $emp1['First_Name'] == $emp2['firstName']
                ) {
                    $merged_data[] = [
                        'employeeNumber' => $emp2['employeeNumber'] ?? "null",
                        'fullName' => $emp1['First_Name'] . ' ' . $emp1['Last_Name'],
                        'ssn' => $emp2['ssn'] ?? "null",
                        'address1' => $emp1['Address1'] ?? "null",
                        'city' => $emp1['City'] ?? "null",
                        'email' => $emp1['Email'] ?? "null",
                        'phoneNumber' => $emp1['Phone_Number'] ?? "null",
                        'gender' => $emp1['Gender'] ?? "null",
                        'shareholder' => $emp1['Shareholder'] ?? "null",
                        'vacationDays' => $emp2['vacationDays'] ?? "null",
                        'payRate' => $emp2['payRate'] ?? "null"
                    ];
                    $matched_ids[] = $emp1['Employee_ID'];
                    $matched = true;
                    break;
                }
            }

            if (!$matched) {
                $merged_data[] = [
                    'employeeNumber' => "null",
                    'fullName' => $emp1['First_Name'] . ' ' . $emp1['Last_Name'],
                    'ssn' => "null",
                    'address1' => $emp1['Address1'] ?? "null",
                    'city' => $emp1['City'] ?? "null",
                    'email' => $emp1['Email'] ?? "null",
                    'phoneNumber' => $emp1['Phone_Number'] ?? "null",
                    'gender' => $emp1['Gender'] ?? "null",
                    'shareholder' => $emp1['Shareholder'] ?? "null",
                    'vacationDays' => "null",
                    'payRate' => "null"
                ];
            }
        }

        foreach ($dataset2 as $emp2) {
            if (!in_array((int)$emp2['idEmployee'], $matched_ids)) {
                $merged_data[] = [
                    'employeeNumber' => $emp2['employeeNumber'],
                    'fullName' => $emp2['firstName'] . ' ' . $emp2['lastName'],
                    'ssn' => $emp2['ssn'],
                    'address1' => "null",
                    'city' => "null",
                    'email' => "null",
                    'phoneNumber' => "null",
                    'gender' => "null",
                    'shareholder' => "null",
                    'vacationDays' => $emp2['vacationDays'],
                    'payRate' => $emp2['payRate']
                ];
            }
        }

        return [
            'total_employees' => count($merged_data),
            'total_pay_rate' => array_sum(array_map(fn($e) => $e['payRate'] !== "null" ? (float)$e['payRate'] : 0, $merged_data)),
            'merged_data' => $merged_data
        ];
    }
}

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new DataBroadcaster()
        )
    ),
    8081
);

$server->run();
