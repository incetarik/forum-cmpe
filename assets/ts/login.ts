namespace Login {
  export let form: HTMLFormElement
  export let idInput: HTMLInputElement
  export let passwordInput: HTMLInputElement
  export let loginButton: HTMLButtonElement
  export let errorHeader: HTMLHeadingElement
  export let formGroups: HTMLDivElement[]

  let cannotLogin = (1 << 0) | (1 << 1)

  Global.extendOnLoad(() => {
    form = document.querySelector('.login form')
    formGroups = Global.slice(form.querySelectorAll('.form-group'))
    errorHeader = form.querySelector('h3.error-info')
    idInput = formGroups[0].querySelector('input')
    passwordInput = formGroups[1].querySelector('input')
    loginButton = formGroups[2].querySelector('button')
  })

  Global.extendOnLoad(() => {
    idInput.oninput = function () {
      const { validationMessage } = idInput
      idInput.classList.remove('error', 'success')

      if (validationMessage) {
        cannotLogin |= 1 << 0
        idInput.classList.add('error')
        return
      }

      cannotLogin &= ~(1 << 0)
      idInput.classList.add('success')
    }

    passwordInput.oninput = function () {
      const { validationMessage } = passwordInput
      passwordInput.classList.remove('error', 'success')

      if (validationMessage) {
        cannotLogin |= 1 << 1
        passwordInput.classList.add('error')
        return
      }

      cannotLogin &= ~(1 << 1)
      passwordInput.classList.add('success')
    }

    let loggingIn = false
    loginButton.onclick = function () {
      if (loggingIn) return
      loggingIn = true
      errorHeader.innerText = ''

      if (cannotLogin) {
        errorHeader.innerText = 'Please check your inputs'
        loggingIn = false
        return
      }

      Global.post('/api/users.php?f=login', { username: idInput.value, password: passwordInput.value }, response => {
        loggingIn = false
        const { data, success } = response
        if (!success || !data) {
          errorHeader.innerText = 'Failed to login'
          return
        }

        errorHeader.innerText = ''
        location.href = '/'
      })
    }
  })
}
