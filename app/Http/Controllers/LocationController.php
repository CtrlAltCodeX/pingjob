<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getStatesOption(Request $request){
        $states = State::whereCountryId($request->country_id)->get();

        //Get the states from country
        $option = "<option value=''>Select a state</option>";
        if ($states->count()){
            foreach ($states as $state){
                $option .= "<option value='{$state->id}'>{$state->state_name}</option>";
            }
        }

        return ['success' => true, 'state_options' => $option];
    }

      public function getCityOption(Request $request){
        $city = City::whereStateId($request->state_id)->get();

        //Get the cities from state
        $option = "<option value=''>Select a city</option>";
        if ($city->count()){
            foreach ($city as $cities){
                $option .= "<option value='{$cities->id}'>{$cities->name}</option>";
            }
        }

        return ['success' => true, 'city_options' => $option];
    }




}
