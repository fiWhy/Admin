{{ session.flash() }}
{{ bsform.create('User', {'controller': 'Users', 'action': 'login'}) }}
{{ bsform.input('username') }}
{{ bsform.input('password') }}
{{ bsform.end('Login') }}