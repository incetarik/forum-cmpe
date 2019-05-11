namespace Entry {
  const awaitingLikeEntries = []

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
}
