function SignUp() {
  const username    = $('#username').val();
  const password    = $('#password').val();
  const cpassword   = $('#cpassword').val();
  const inviteToken = $('#invite_token').val();
  const reflink     = getCookie('ref_code');

  if (!username || !password || !cpassword) {
    Toastify({ text: 'Bitte alle Felder ausfüllen!', duration: 2500, position: 'right', style: { background: 'red' } }).showToast();
    return;
  }

  $.ajax({
    url: '/api/auth/create',   // ✅ HIER
    type: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({
      username,
      password,
      cpassword,
      invite_token: inviteToken,
      reflink
    }),
    success: function (parsed) {
      // Vercel API gibt schon JSON zurück -> kein JSON.parse nötig
      if (parsed.status === 'error') {
        Toastify({ text: parsed.message, duration: 2500, position: 'right', style: { background: 'red' } }).showToast();
      } else {
        Toastify({ text: parsed.message, duration: 2500, position: 'right', style: { background: '#ed51c1' } }).showToast();
        if (reflink) deleteCookie('ref_code');
        setTimeout(() => window.location.href = 'home.html', 1200);
      }
    }
  });
}

function SignIn() {
  const username = $('#lusername').val();
  const password = $('#lpassoword').val();

  if (!username || !password) {
    Toastify({ text: 'Bitte alle Felder ausfüllen!', duration: 2500, position: 'right', style: { background: 'red' } }).showToast();
    return;
  }

  $.ajax({
    url: '/api/auth/login',   // ✅ HIER
    type: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({ username, password }),
    success: function (parsed) {
      if (parsed.status === 'error') {
        Toastify({ text: parsed.message, duration: 2500, position: 'right', style: { background: 'red' } }).showToast();
      } else {
        Toastify({ text: parsed.message, duration: 2500, position: 'right', style: { background: '#ed51c1' } }).showToast();
        setTimeout(() => window.location.href = 'home.html', 350);
      }
    }
  });
}

// Cookie helper (wie bei dir)
function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  return parts.length === 2 ? parts.pop().split(';').shift() : null;
}
function deleteCookie(name) {
  document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT; Secure;';
}