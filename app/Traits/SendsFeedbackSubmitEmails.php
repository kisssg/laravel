<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Traits;

use Illuminate\Http\Request;
/**
 * Description of SendsFeedbackSubmitEmails
 *
 * @author Sucre.xu
 */
trait SendsFeedbackSubmitEmails
{
    //put your code here
    public function sendFeedbackLinkEmail(Request $reauest){
        $this->validateEmail($reauest);
    }
    
    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }
}
