document.addEventListener("click", () => {
    fetch('/track-activity', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ activity: 'click' })
    }).catch(error => console.error('Activity tracking failed:', error));
});
