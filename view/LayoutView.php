<?php


class LayoutView {
  
    private $isLoggedIn = false;
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
     * Echo all the views
     * @param HTMLView $v
     * @param DateTimeView $dtv
     * @param RegisterView $rv
     * @param User $user
     */
    public function render(HTMLView $v, DateTimeView $dtv, RegisterView $rv, User $user)
    {
        $response = $v->getView();
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
