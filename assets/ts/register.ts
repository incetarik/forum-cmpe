namespace Register {
  export let form: HTMLElement
  export let idInput: HTMLInputElement
  export let nameInput: HTMLInputElement
  export let surnameInput: HTMLInputElement
  export let mailInput: HTMLInputElement
  export let passwordInput: HTMLInputElement
  export let passwordAgainInput: HTMLInputElement
  export let registerButton: HTMLButtonElement
  export let errorHeader: HTMLHeadingElement
  export let formGroups: HTMLDivElement[]

  let cannotSend = ~(1 << 6)
  let registerProtectionCodeInput: HTMLInputElement

  Global.extendOnLoad(() => {
    form = document.querySelector('.login.register');
    formGroups = Global.slice(form.querySelectorAll('.form-group'))
    idInput = formGroups[0].querySelector('input')
    nameInput = formGroups[1].querySelector('input')
    surnameInput = formGroups[2].querySelector('input')
    mailInput = formGroups[3].querySelector('input')
    passwordInput = formGroups[4].querySelector('input')
    passwordAgainInput = formGroups[5].querySelector('input')
    registerButton = formGroups[6].querySelector('button')

    registerProtectionCodeInput = form.querySelector('input[type=hidden]')
    errorHeader = form.querySelector('h3')
  })

  Global.extendOnLoad(() => {
    idInput.oninput = function () {
      const { validationMessage } = idInput
      idInput.reportValidity()
      if (validationMessage) {
        cannotSend |= 1 << 0
        idInput.classList.remove('error', 'success')
        return
      }

      cannotSend &= ~(1 << 0)

      const username = idInput.value
      Global.post('/api/users.php?f=check_username', { username }, (value) => {
        const { success, data } = value
        if (!success || !data) {
          cannotSend |= 1 << 0
          idInput.classList.add('error')
          idInput.classList.remove('success')
        }
        else {
          cannotSend &= ~(1 << 0)
          idInput.classList.remove('error')
          idInput.classList.add('success')
        }
      })
    }

    mailInput.oninput = function () {
      const { validationMessage } = mailInput
      mailInput.reportValidity()
      mailInput.classList.remove('error', 'success')
      if (validationMessage) {
        mailInput.classList.add('error')
        cannotSend |= 1 << 1
        return
      }

      cannotSend &= ~(1 << 1)

      const mail = mailInput.value
      Global.post('/api/users.php?f=check_mail', { mail }, value => {
        const { success, data } = value
        if (!success || !data) {
          cannotSend |= 1 << 1
          mailInput.classList.add('error')
          mailInput.classList.remove('success')
        }
        else {
          cannotSend &= ~(1 << 1)
          mailInput.classList.remove('error')
          mailInput.classList.add('success')
        }
      })
    }

    let currentPassword = ''
    passwordInput.oninput = function () {
      currentPassword = passwordInput.value
      const { validationMessage } = passwordInput
      passwordInput.reportValidity()
      passwordInput.classList.remove('error')
      if (validationMessage) {
        cannotSend |= 1 << 2
        currentPassword = ''
        passwordInput.classList.add('error')
        return
      }

      cannotSend &= ~(1 << 2)
    }

    passwordAgainInput.oninput = function () {
      const value = passwordAgainInput.value
      const { validationMessage } = passwordAgainInput
      if (validationMessage) return

      passwordAgainInput.classList.remove('success', 'error')
      passwordInput.classList.remove('success')

      if (!currentPassword || (value !== currentPassword)) {
        if (!passwordAgainInput.classList.contains('error')) {
          passwordAgainInput.classList.add('error')
          return
        }

        cannotSend |= 1 << 3
        return
      }

      cannotSend &= ~(1 << 3)

      passwordAgainInput.classList.add('success')
      passwordAgainInput.classList.remove('error')

      passwordInput.classList.add('success')
    }

    nameInput.oninput = function () {
      const { validationMessage } = nameInput

      nameInput.classList.remove('success', 'error')
      if (validationMessage) {
        cannotSend |= 1 << 4
        nameInput.classList.add('error')
        return
      }

      cannotSend &= ~(1 << 4)
      nameInput.classList.add('success')
    }

    surnameInput.oninput = function () {
      const { validationMessage } = surnameInput

      surnameInput.classList.remove('error', 'success')
      if (validationMessage) {
        cannotSend |= 1 << 5
        surnameInput.classList.add('error')
        return
      }

      cannotSend &= ~(1 << 5)
      surnameInput.classList.add('success')
    }

    registerButton.onclick = function () {
      if (cannotSend) {
        errorHeader.innerText = 'Please check your inputs'
        return
      }

      const data = {
        username: idInput.value,
        password: currentPassword,
        email: mailInput.value,
        validationToken: registerProtectionCodeInput.value,
        name: nameInput.value,
        surname: surnameInput.value,
      }

      Global.post('/api/users.php?f=register', data, response => {
        const { success, data } = response
        errorHeader.innerText = ''

        if (!success || !data) {
          errorHeader.innerText = 'Register failed'
        }
        else {
          location.href = '/'
        }
      })
    }
  })
}
