<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'customer_name' => fake()->name(),
            'occupation' => fake()->text(190),
            'Remarks' => fake()->text(190),
            'nid_number' => fake()->phoneNumber(),
            'gender' => fake()->numberBetween($min = 0, $max = 2),
            'date_of_birth' => fake()->date(),
            'reg_form_no' => fake()->text(190),
            'road_no' => fake()->text(190),
            'reg_form_pic' => fake()->text(190),
            'fb_id' => fake()->text(190),
            'father_or_husband_name' => fake()->name(),
            'mother_name' => fake()->name(),
            'mobile1' => fake()->phoneNumber(),
            'mobile2' => fake()->phoneNumber(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'blood_group' => fake()->randomLetter(),
            'district_id' => fake()->randomNumber(),
            'upazila_id' => fake()->randomNumber(),
            'village' => fake()->randomNumber(),
            'house_no' => fake()->randomNumber(),
            'business_type_id' => fake()->randomNumber(),
            'latitude' => fake()->randomNumber(),
            'longitude' => fake()->randomNumber(),
            'present_address' => fake()->address(),
            'permanent_address' => fake()->address(),
            'contract_person' => fake()->name(),
            'server_id' => fake()->randomNumber(),
            'protocol_typeid' => fake()->randomNumber(),
            'area_id' => fake()->randomNumber(),
            'tbl_zone_id' => fake()->randomNumber(),
            'subzone_id' => fake()->randomNumber(),
            'box_id' => fake()->randomNumber(),
            'bandwidth_plan_id' => fake()->randomNumber(),
            'cable_req' => fake()->randomNumber(),
            'fiber_code' => fake()->randomNumber(),
            'no_of_core' => fake()->randomNumber(),
            'core_color' => fake()->randomNumber(),
            'device' => fake()->randomNumber(),
            'mac_address' => fake()->text(190),
            'device_vendor_id' => fake()->randomNumber(),
            'purchase_date' => fake()->date(),
            'tbl_client_type_id' => fake()->randomNumber(),
            'customer_type' => fake()->randomNumber(),
            'username' => fake()->userName(),
            'billing_month' => fake()->month(),
            'profile_id' => fake()->randomNumber(),
            'network_password' => fake()->password(),
            'expiry_date' => fake()->date(),
            'block_date' => fake()->date(),
            'joining_date' => fake()->date(),
            'vat_Status' => fake()->boolean(),
            'include_vat' => fake()->boolean(),
            'billing_status_id' => fake()->randomNumber(),
            'connection_employee_id' => fake()->randomNumber(),
            'reference_by' => fake()->randomNumber(),
            'monthly_bill' => fake()->numberBetween($min = 0, $max = 1000),
            'rate_amnt' => fake()->numberBetween($min = 0, $max = 1000),
            'vat_amnt' => fake()->numberBetween($min = 0, $max = 1000),
            'ac_no' => fake()->numberBetween($min = 0, $max = 1000),
            'greeting_sms_sent' => fake()->boolean(),
            'profile_pic' => fake()->text(190),
            'nid_pic' => fake()->text(190),
            'ip_number' => fake()->text(100),
            'radcheck_id' => fake()->randomNumber(),
            'tbl_client_category_id' => fake()->randomNumber(),
            'tbl_srv_type_id' => fake()->randomNumber(),
            'tbl_bill_cycle_id' => fake()->randomNumber(),
            'block_reason_id' => fake()->randomNumber(),
            'tbl_bill_type_id' => fake()->randomNumber(),
            'tbl_status_type_id' => fake()->randomNumber(),
            'tbl_bandwidth_plan_id' => fake()->randomNumber(),
            'router_id' => fake()->randomNumber(),
            'trn_clients_service_ratechange_id' => fake()->randomNumber()
        ];
    }
}
