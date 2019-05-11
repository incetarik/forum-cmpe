namespace Entry {
  const awaitingLikeEntries = []
  let replyButton: HTMLAnchorElement
  let titleInput: HTMLInputElement
  let contentInput: HTMLInputElement

  Global.extendOnLoad(() => {
    replyButton = document.getElementById('reply') as HTMLAnchorElement
    titleInput = document.getElementById('title') as HTMLInputElement
    contentInput = document.getElementById('content') as HTMLInputElement
  })

  export function toggleLike(entryId: number, callback?: (state: 'like' | 'dislike') => void) {
    if (~awaitingLikeEntries.indexOf(entryId)) return
    awaitingLikeEntries.push(entryId)

    Global.post('/api/entries.php?f=toggle_like_entry', { entry: entryId }, (result => {
      const index = awaitingLikeEntries.indexOf(entryId)
      if (~index) awaitingLikeEntries.splice(index, 1)

      if (typeof result === 'object' && 'success' in result && result['success']) {
        if (typeof callback === 'function') {
          callback(result.data)
        }

        const button = document.getElementById(`like_button_${entryId}`)
        if (!button) return
        button.innerText = result.data[0] == 'd' ? 'Like' : 'Dislike'
      }
    }))
  }

  export function addComment(title: string, content: string, entryId: number, userId: number, userFullName: string, jobTitle: string) {
    Global.post('/api/entries.php?f=add_comment', {
      entry: entryId,
      title,
      content
    }, (result) => {
      if (result && result.data > 0) {
        const article = createArticleElement(title, content, entryId, userId, userFullName, jobTitle)
        replyButton.parentElement.parentElement.before(article)
        if (titleInput) titleInput.value = ''
        if (contentInput) contentInput.value = ''
      }
    })
  }

  function createArticleElement(title: string, content: string, entryId: number, userId: number, userFullName: string, jobTitle: string) {
    const article = document.createElement('article')
    article.className = 'article'
    const personDiv = document.createElement('div')
    personDiv.className = 'person'
    const personImg = document.createElement('img')
    personImg.src = '/assets/img/avatar/' + userId + '.jpg'
    personImg.alt = userFullName
    const h3 = document.createElement('h3')
    h3.innerText = userFullName
    let p = document.createElement('p')
    p.innerText = jobTitle

    personDiv.append(personImg)
    personDiv.append(h3)
    personDiv.append(p)

    const textDiv = document.createElement('div')
    if (title) {
      const text = document.createElement('h2')
      text.innerText = title
      textDiv.append(text)
    }

    p = document.createElement('p')
    p.innerText = content
    textDiv.append(p)
    article.append(personDiv)
    article.append(textDiv)
    return article
  }
}
