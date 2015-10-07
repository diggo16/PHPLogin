<?php


class LayoutView {
  
    private $isLoggedIn = false;
    /**
     * Echo all the views
     * @param LoginView $v
     * @param DateTimeView $dtv
     */
    public function render(LoginView $v, DateTimeView $dtv, RegisterView $rv) 
    {
        $response = $this->getCorrectResponse($v, $rv);
        $registerResponse = $rv->generateTextLink($this->isLoggedIn);
        echo '<!DOCTYPE html>
        <html>
          <head>
            <meta charset="utf-8">
            <title>Login Example</title>
          </head>
          <body>
            <h1>Assignment 2</h1>
            ' . $registerResponse . $this->renderIsLoggedIn() . '

            <div class="container">
                ' . $response . '

                ' . $dtv->show() . '
            </div>
           </body>
        </html>
      ';
    }

    /**
     * Check if the user is logged in
     * @param boolean $isLoggedIn
     * @return string htmlString
     */
    private function renderIsLoggedIn() {
      if ($this->isLoggedIn) {
        return '<h2>Logged in</h2>';
      }
      else {
        return '<h2>Not logged in</h2>';
      }
    }
    /**
     * Check what view that should be shown
     * @param LoginView $v
     * @param RegisterView $rv
     * @return var $response
     */
    private function getCorrectResponse(LoginView $v, RegisterView $rv)
    {
        $response = "";
        //if register text is clicked, show the RegisterView
        if($rv->isRegisterTextClicked())
        {
            $response = $rv->generateRegisterForm();
            //If the registration was correct, return to login form
            if($response == "")
            {
                header('Location: ?');
                //$response = $v->responseWithParameters($rv->getSuccessfulFeedback(), $rv->getUsername());
                //$this->isLoggedIn = false;
            }
        }
        //Else show the LoginView
        else
        {
            $username = $rv->getTempUsername();
            if($username != "")
            {
                $response = $v->responseWithParameters($rv->getSuccessfulFeedback(), $username);
                $this->isLoggedIn = false;
            }
            else
            {
                $response = $response = $v->response();
                $this->isLoggedIn = $v->isLoggedIn();
            }
            
        }
        return $response;
    }
    public function newRender(LoginView $v, DateTimeView $dtv, RegisterView $rv, User $user)
    {
        $response = $v->responseWithUser($user);
        $this->isLoggedIn = $user->isLoggedIn();
        $registerResponse = $rv->generateTextLink($this->isLoggedIn);
        echo '<!DOCTYPE html>
        <html>
          <head>
            <meta charset="utf-8">
            <title>Login Example</title>
          </head>
          <body>
            <h1>Assignment 2</h1>
            ' . $registerResponse . $this->renderIsLoggedIn() . '

            <div class="container">
                ' . $response . '

                ' . $dtv->show() . '
            </div>
           </body>
        </html>
      ';
        
    }
}
