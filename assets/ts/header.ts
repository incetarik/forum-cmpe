namespace Header {
  Global.extendOnLoad(() => {
    Global.slice(document.querySelectorAll('.user button')).forEach((item: HTMLButtonElement) => {
      item.onclick = function () {
        location.href = item.dataset['target']
      }
    })
  })
}
