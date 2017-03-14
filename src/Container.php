<?php

namespace MCMIS\Workflow;


class Container
{

    private $allowed_status = [
        'reader' => [],
        'admin' => [],
        'operator' => [
            'validate', 'pending', 'discard'
        ],
        'supervisor' => [
            'forwarded.department', 'assigned.staff', 'staff.attended', 'resolved'
        ],
        'fieldworker' => [
            'assigned.staff', 'in.process', 'reschedule', 'staff.attended', 'staff.delayed'
        ],
    ];

    private $hierarchy = [
        'reader' => [
            'reader',
        ],
        'admin' => [
            'admin', 'operator', 'supervisor', 'fieldworker',
        ],
        'operator' => [
            'operator',
        ],
        'supervisor' => [
            'supervisor', 'fieldworker',
        ],
        'fieldworker' => [
            'fieldworker',
        ],
    ];

    public function hasFlow($role, $status){
        return array_intersect($this->allowed_status[$role], $this->get($status));
    }

    public function get($status){
        $output = [];
        switch($status){
            case 'validate':
                $output = [
                    'validate', 'pending', 'discard'
                ];
                break;
            case 'pending':
                $output = [
                    'pending', 'discard'
                ];
                break;
            case 'discard':
                $output = [
                    'discard'
                ];
                break;
            case 'forwarded.department':
                $output = [
                    'forwarded.department'
                ];
                break;
            case 'assigned.staff':
                $output = [
                    'assigned.staff', 'in.process', 'reschedule'
                ];
                break;
            case 'in.process':
                $output = [
                    'in.process', 'staff.attended'
                ];
                break;
            case 'reschedule':
                $output = [
                    'reschedule', 'in.process'
                ];
                break;
            case 'staff.attended':
                $output = [
                    'staff.attended', 'resolved'
                ];
                break;
            case 'staff.delayed':
                $output = [
                    'staff.delayed', 'in.process', 'reschedule'
                ];
                break;
            case 'resolved':
                $output = [
                    'resolved'
                ];
                break;
        }
        return $output;
    }

    public function allowedFlow($role){
        return $this->allowed_status[$role];
    }

    public function canView($role){
        $output = [];
        foreach($this->hierarchy[$role] as $entite){
            foreach($this->allowed_status[$entite] as $status){
                $output[] = $status;
            }
        }
        return array_unique($output);
    }

}