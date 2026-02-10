function toast(text, color = "#ed51c1") {
  Toastify({
    text,
    duration: 2500,
    position: "right",
    style: { background: color }
  }).showToast();
}

function SignUp() {
  console.log("SignUp clicked");

  const username    = $('#username').val();
  const password    = $('#password').val();
  const cpassword   = $('#cpassword').val();
  const inviteToken = $('#invite_token').val();
  const reflink     = getCookie('ref_code');

  if (!username || !password || !cpassword) {
    toast("Bitte alle Felder ausfüllen!", "red");
    return;
  }

  $.ajax({
    url: "/api/auth/create",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      username,
      password,
      cpassword,
      invite_token: inviteToken || null,
      reflink: reflink || null
    }),
    success(res) {
      if (res.status === "error") {
        toast(res.message, "red");
      } else {
        toast(res.message);
        if (reflink) deleteCookie("ref_code");
        setTimeout(() => location.href = "home.html", 1200);
      }
    },
    error() {
      toast("Server nicht erreichbar", "red");
    }
  });
}

function SignIn() {
  const username = $('#lusername').val();
  const password = $('#lpassoword').val();

  if (!username || !password) {
    toast("Bitte alle Felder ausfüllen!", "red");
    return;
  }

  $.ajax({
    url: "/api/auth/login",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({ username, password }),

    success(res) {
      if (res && res.status === "success") {
        location.href = "home.html";
      } else {
        toast(res?.message || "Login fehlgeschlagen", "red");
      }
    },

    async error() {
      // Safari/Abort-Fall: prüfen ob Session-Cookie gesetzt wurde
      try {
        const r = await fetch("/api/auth/me", { credentials: "include" });
        const d = await r.json();
        if (d.auth) return (location.href = "home.html");
      } catch {}
      toast("Login fehlgeschlagen", "red");
    }
  });
}

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  return parts.length === 2 ? parts.pop().split(';').shift() : null;
}

function deleteCookie(name) {
  document.cookie = name + "=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT; Secure;";
}