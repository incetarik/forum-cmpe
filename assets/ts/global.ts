namespace Global {
  let _loadCompleted = false

  export let header: HTMLElement
  export let footer: HTMLElement
  export let sidebar: HTMLElement
  export let menu: HTMLElement
  export let logo: HTMLElement

  extendOnLoad(() => {
    header = document.querySelector('header')
    footer = document.querySelector('footer')
    sidebar = document.getElementById('sidebar')
    menu = document.getElementById('menu')
    logo = document.getElementById('logo')

    document.onscroll = sideBarScrollHandler
  })








  // ───────────────────────────[ Helpers ]────────────────────────────────────

  export function extendOnLoad(handler: Function) {
    if (_loadCompleted) {
      handler.call(window)
      return
    }

    const previous = window.onload
    window.onload = function () {
      _loadCompleted = true
      if (typeof previous === 'function') previous.call(window)
      handler.call(window)
    }

    return window
  }

  function sideBarScrollHandler() {
    const style = sidebar.style
    const menuClassList = menu.classList
    const logoClassList = logo.classList

    if (scrollY >= 64) {
      menuClassList.add('fixed')
      logoClassList.add('fixed')
    }
    else {
      menuClassList.remove('fixed')
      logoClassList.remove('fixed')
    }

    if (scrollY <= 70) {
      style.marginTop = (-scrollY).toString().concat('px')
    }
    else {
      style.marginTop = '-68px'
    }
  }
}

