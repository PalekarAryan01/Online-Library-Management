function reserveBook(bookId) {
    fetch('reserve_book.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ bookId: bookId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Book reserved successfully!');
        } else {
            alert('Failed to reserve the book.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while reserving the book.');
    });
}
