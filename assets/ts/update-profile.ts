namespace UpdateProfile {
  let saveButton: HTMLButtonElement
  let nameInput: HTMLInputElement
  let surnameInput: HTMLInputElement
  let emailInput: HTMLInputElement
  let jobTitleInput: HTMLInputElement
  let passwordInput: HTMLInputElement
  let imageFileInput: HTMLInputElement
  let profilePictureImage: HTMLImageElement
  declare const defaultValues: any

  Global.extendOnLoad(() => {
    saveButton = document.getElementById('saveButton') as HTMLButtonElement
    saveButton.onclick = updateProfile

    nameInput = document.getElementById('name') as HTMLInputElement
    surnameInput = document.getElementById('surname') as HTMLInputElement
    emailInput = document.getElementById('email') as HTMLInputElement
    jobTitleInput = document.getElementById('jobTitle') as HTMLInputElement
    passwordInput = document.getElementById('password') as HTMLInputElement
    profilePictureImage = document.getElementById('pp') as HTMLImageElement

    imageFileInput = document.getElementById('imageFileInput') as HTMLInputElement
    imageFileInput.onclick = onChangePicture;

    document.getElementById('removeMe').remove()
  })

  export function updateProfile() {
    const changes = {}
    const {
      name: prevName,
      surname: prevSurname,
      email: prevEmail,
      jobTitle: prevJobTitle
    } = defaultValues

    if (!checkButton()) return

    const name = nameInput.value
    const surname = surnameInput.value
    const email = emailInput.value
    const jobTitle = jobTitleInput.value
    const password = passwordInput.value

    if (!name && !surname && !email && !jobTitle && !password) return

    if (name && (name != prevName)) changes['name'] = name
    if (surname && (surname != prevSurname)) changes['surname'] = surname
    if (email && (email != prevEmail)) changes['email'] = email
    if (jobTitle && (jobTitle != prevJobTitle)) changes['jobTitle'] = jobTitle
    if (password) changes['password'] = password

    changes['__update_form_validation'] = getValidation()
    Global.post('/api/users.php?f=update', changes, (result) => {
      location.reload()
    })
  }

  export function updateButton() {
    saveButton.disabled = !checkButton()
  }

  export function triggerImageClick() {
    imageFileInput.click()
  }

  function checkButton() {
    if (!nameInput.reportValidity()) return false
    if (!surnameInput.reportValidity()) return false
    if (!emailInput.reportValidity()) return false
    if (!jobTitleInput.reportValidity()) return false
    if (!passwordInput.reportValidity()) return false

    return true
  }

  let waitingIntervalId = 0
  export function onChangePicture() {
    if (!waitingIntervalId) {
      waitingIntervalId = setInterval(onChangePicture, 300)
      return
    }

    const { files } = imageFileInput
    if (!files.length) return
    clearInterval(waitingIntervalId)
    waitingIntervalId = 0
    const data = new FormData()
    data.append('image', files[0])
    Global.post('/api/users.php?f=change_pp', data, () => {
      setTimeout(() => {
        const old = profilePictureImage.src
        profilePictureImage.src = ''
        profilePictureImage.src = old
      }, 1000)
    })
  }

  function getValidation() {
    const input: HTMLInputElement = document.querySelector('input[type=hidden]')
    return input.value
  }
}
