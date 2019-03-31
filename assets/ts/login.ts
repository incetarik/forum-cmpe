namespace Login {
  export let form: HTMLFormElement
  export let idInput: HTMLInputElement
  export let passwordInput: HTMLInputElement
  export let loginButton: HTMLButtonElement
  export let formGroups: HTMLDivElement[]

  Global.extendOnLoad(() => {
    form = document.querySelector('.login form')
    formGroups = Global.slice(form.querySelectorAll('.form-group'))
    idInput = formGroups[0].querySelector('input')
    passwordInput = formGroups[1].querySelector('input')
    loginButton = formGroups[2].querySelector('button')
  })

  Global.extendOnLoad(() => {
    loginButton.onclick = function () {

    }
  })
}
