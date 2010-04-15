<?php

print (form_open('user/login', 'id="login_form"'));
print ('<label for="username_email" class="inlined">'. $this->lang->line('entry_username_email') .'</label>');
print (form_input('username_email', '', 'class="required textbox" title="'. $this->lang->line('error_required_username_email') .'"'));
print ('<label for="password" class="inlined">'. $this->lang->line('entry_password') .'</label>');
print (form_password('password', '', 'class="required textbox" title="'. $this->lang->line('error_required_password') .'"'));
print ('<div id="msg_div">'.$this->lang->line($msg).'</div>');
print (anchor('user/lost_my_password', $this->lang->line('entry_lost_my_password')));
print (' &nbsp; ');
print ($this->guest->guest_link('user/login/as_guest', $this->lang->line('entry_i_am_a_guest')));
print (form_submit('submit', $this->lang->line('entry_login')));
print (form_close());
