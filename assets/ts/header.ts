namespace Header {
  Global.extendOnLoad(() => {
    const [ loginButton, registerButton ] = Global.slice(document.querySelectorAll('.user button'))
    loginButton.onclick = () => {
      location.href = '/login.php'
    }

    registerButton.onclick = () => {
      location.href = '/register.php'
    }
  })


}
