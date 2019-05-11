namespace Global {
  let _loadCompleted = false
  export function slice(items) {
    return Array.prototype.slice.call(items)
  }

  export let header: HTMLElement
  export let footer: HTMLElement
  export let sidebar: HTMLElement
  export let menu: HTMLElement
  export let logo: HTMLElement

  export let currentLocation: string
  export let currentQuery: string

  extendOnLoad(() => {
    header = document.querySelector('header')
    footer = document.querySelector('footer')
    sidebar = document.getElementById('sidebar')
    menu = document.getElementById('menu')
    logo = document.getElementById('logo')

    if (sidebar) {
      // document.onscroll = sideBarScrollHandler
    }

    currentLocation = location.pathname
    const index = currentLocation.indexOf('?')
    if (~index) {
      currentQuery = currentLocation.substr(index + 1)
      currentLocation = currentLocation.substr(0, index)
    }
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

  export function get(url: string, callback: Function) {
    const xmlhttp = new XMLHttpRequest()
    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        callback(xmlhttp.responseText);
      }
    }

    xmlhttp.responseType = 'json'
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
  }

  export function post(url: string, data: any, callback: Function) {
    let formData
    if (data instanceof FormData) {
      formData = data
    }
    else {
      formData = new FormData()
    }

    if (data) {
      for (const key in data) {
        const value = data[key]
        formData.append(key, value.toString())
      }
    }

    const xmlhttp = new XMLHttpRequest()
    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        callback(xmlhttp.response);
      }
    }

    xmlhttp.responseType = 'json'
    xmlhttp.open("POST", url, true);
    xmlhttp.send(formData);
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

  export function deleteSidebarContent(contentId: number, userRemovalKey: string) {
    return Global.post(`/api/sidebar_contents.php?f=delete`, {
      key: userRemovalKey,
      id: contentId,
    }, (result) => {
      if (typeof result === 'object' && 'data' in result && result['data'] == 1) {
        const element = document.getElementById(`del_sbc_${contentId}`)
        const head = element.parentElement
        if (!head) return
        const article = head.nextElementSibling
        head.remove()
        if (!article) return
        article.remove()
      }
    })
  }
}

