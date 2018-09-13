<?php

$tips_assembly = [
    'pcb_supplied_by' => '',
    'components_supplied_by' => '',
    'pcb_assembly_quantity' => 'Your desired quantity of PCBA. Our MOQ is 1pcs.',
    'unique_number_of_parts' => 'The quantity of BOM line items.',
    'smt_pads_per_board' => 'The quantity of SMT pads on each board. For example 0805/0603/0402 package has 2 SMT pads, SOIC-16 has 16 SMT pads. ',
    'tht_pins_per_board' => 'The quantity of Through Hole Pins on each board. For example SOP14 has 14 Through Hole Pins.',
    'no_lead_pads_per_board' => 'Leadless SMT pads like QFN, BGA',
    'single_double_sided' => 'Are the parts assembled on only one side or both sides?',
    'fpcb_assembly' => '',
    'bga_pitch' => '',
    'short_circuit_testing' => 'Check whether the critical circuit (especially the power supply and ground) is shorted.',
    'power_on_testing' => "Check power supply's output",
    'firmware_flashing' => 'The process of transferring a program into an integrated circuit. Hex file, fuse setting, tooling, etc. are required.',
    'functional_testing' => 'Functional test defined by customers. Testing manual and tooling need to be adviced in details.',
    'design_tester' => 'Do you need us to to design a tester jig for testing?',
    'build_tester' => 'Do you need us to to build a tester jig for testing?',
    'x_ray' => 'Automated X-ray inspection. It uses X-rays as its source, instead of visible light, to automatically inspect features, which are typically hidden from view. It is necessary for BGA.  https://en.wikipedia.org/wiki/Automated_X-ray_inspection',
    'aoi' => 'Automated Optical Inspection https://en.wikipedia.org/wiki/Automated_optical_inspection',
    'estimate_of_testing_time' => ''
];

$options_value = [
    'single_double_sided' => [
        ['name' => 'Single', 'value' => 'Single', 'selected' => 'selected'],
        ['name' => 'Double', 'value' => 'Double', 'selected' => ''],
    ],
    'fpcb_assembly' => [
        ['name' => 'No', 'value' => 'No', 'selected' => 'selected'],
        ['name' => 'Yes', 'value' => 'Yes', 'selected' => ''],
    ],
    'bga_pitch' => [
        ['name' => 'No BGA', 'value' => 'No BGA', 'selected' => 'selected'],
        ['name' => '0.35 mm', 'value' => '0.35 mm', 'selected' => ''],
        ['name' => '0.30 mm', 'value' => '0.30 mm', 'selected' => ''],
        ['name' => '0.25 mm', 'value' => '0.25 mm', 'selected' => '']
    ],
    'short_circuit_testing' => [
        ['name' => 'No', 'value' => 'No', 'selected' => 'selected'],
        ['name' => 'Yes', 'value' => 'Yes', 'selected' => ''],
    ],
    'power_on_testing' => [
        ['name' => 'No', 'value' => 'No', 'selected' => 'selected'],
        ['name' => 'Yes', 'value' => 'Yes', 'selected' => ''],
    ],
    'firmware_flashing' => [
        ['name' => 'No', 'value' => 'No', 'selected' => 'selected'],
        ['name' => 'Yes', 'value' => 'Yes', 'selected' => ''],
    ],
    'functional_testing' => [
        ['name' => 'No', 'value' => 'No', 'selected' => 'selected'],
        ['name' => 'Yes', 'value' => 'Yes', 'selected' => ''],
    ],
    'design_tester' => [
        ['name' => 'Not Needed', 'value' => 'Not Needed', 'selected' => 'selected'],
        ['name' => 'Smart Prototyping', 'value' => 'Smart Prototyping', 'selected' => ''],
        ['name' => 'Me', 'value' => 'Me', 'selected' => ''],
    ],
    'build_tester' => [
        ['name' => 'Not Needed', 'value' => 'Not Needed', 'selected' => 'selected'],
        ['name' => 'Smart Prototyping', 'value' => 'Smart Prototyping', 'selected' => ''],
        ['name' => 'Me', 'value' => 'Me', 'selected' => ''],
    ],
    'x_ray' => [
        ['name' => 'No', 'value' => 'No', 'selected' => 'selected'],
        ['name' => 'Yes', 'value' => 'Yes', 'selected' => ''],
    ],
    'aoi' => [
        ['name' => 'No', 'value' => 'No', 'selected' => 'selected'],
        ['name' => 'Yes', 'value' => 'Yes', 'selected' => ''],
    ],
];
