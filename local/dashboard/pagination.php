
    <style>
            /* Style to display buttons inline */
            #pagination-buttons {
            display: flex;
            align-items: center; /* Vertically center the buttons */
        }

        #pagination-buttons button {
            margin: 5px; /* Add some spacing between buttons */
        }
    </style>

<div id="items">
  <div class="item">Item 1</div>
  <div class="item">Item 2</div>
  <div class="item">Item 3</div>
  <div class="item">Item 4</div>
  <div class="item">Item 5</div>
  <div class="item">Item 6</div>
  <div class="item">Item 7</div>
  <div class="item">Item 8</div>
  <div class="item">Item 9</div>
  <div class="item">Item 10</div>
  <div class="item">Item 11</div>
  <div class="item">Item 12</div>
  <div class="item">Item 13</div>
  <div class="item">Item 14</div>
  <div class="item">Item 15</div>
  <div class="item">Item 16</div>
  <div class="item">Item 17</div>
  <!-- Add more items here -->
</div>

<div id="pagination">
  <div id="pagination-buttons">
    <button id="prev">Previous</button>
    <div id="pageNumbers"></div>
    <button id="next">Next</button>
  </div>
</div>

<script>
// Constants
const itemsPerPage = 4; // Number of items to display per page
let currentPage = 1;   // Current page

// Function to show items based on the current page
function showItems() {
  const items = document.querySelectorAll('.item');
  const startIndex = (currentPage - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;

  items.forEach((item, index) => {
    if (index >= startIndex && index < endIndex) {
      item.style.display = 'block';
    } else {
      item.style.display = 'none';
    }
  });

  // Update the displayed page numbers
  const totalItems = items.length;
  const totalPages = Math.ceil(totalItems / itemsPerPage);
  const pageNumbersDiv = document.getElementById('pageNumbers');
  pageNumbersDiv.innerHTML = '';

  for (let i = 1; i <= totalPages; i++) {
    const pageNumberButton = document.createElement('button');
    pageNumberButton.textContent = i;
    pageNumberButton.addEventListener('click', () => {
      currentPage = i;
      showItems();
    });
    pageNumbersDiv.appendChild(pageNumberButton);
  }
}

// Initialize: Show the first page of items
showItems();

// Pagination event listeners
document.getElementById('prev').addEventListener('click', () => {
  if (currentPage > 1) {
    currentPage--;
    showItems();
  }
});

document.getElementById('next').addEventListener('click', () => {
  const items = document.querySelectorAll('.item');
  const totalItems = items.length;
  const totalPages = Math.ceil(totalItems / itemsPerPage);

  if (currentPage < totalPages) {
    currentPage++;
    showItems();
  }
});
</script>
