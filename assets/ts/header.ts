namespace Header {
  export let navList: HTMLElement
  export let searchButton: HTMLButtonElement

  Global.extendOnLoad(() => {
    Global.slice(document.querySelectorAll('.user button')).forEach((item: HTMLButtonElement) => {
      item.onclick = function () {
        location.href = item.dataset[ 'target' ]
      }
    })

    navList = document.querySelector('nav')
    const { currentLocation } = Global

    Global.slice(navList.querySelectorAll('a')).forEach((item: HTMLAnchorElement, index: number) => {
      item.classList.remove('active')

      if (!currentLocation || currentLocation == '/') {
        if (index === 0) {
          item.classList.add('active')
        }
      }
      else if (~item.href.indexOf(currentLocation)) {
        item.classList.add('active')
      }
    })

    searchButton = document.querySelector('.search button')
  })

  Global.extendOnLoad(() => {
    searchButton.onclick = () => {
      location.href = '/search-result.php'
    }
  })
}
