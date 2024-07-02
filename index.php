<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

  <form action="invoice.php" method="post">
    <h2>Form Surat Resmi</h2>
    <section>
      <h3>Informasi Surat</h3>
      <label for="nomor_surat">Nomor Surat:</label>
      <input type="text" id="nomor_surat" name="nomor_surat" required>
      <label for="tanggal_surat">Tanggal Surat:</label>
      <input type="date" id="tanggal_surat" name="tanggal_surat" required>
      <label for="perihal">Perihal:</lab el>
        <input type="text" id="perihal" name="perihal" required>
    </section>

    <section>
      <h3>Isi Surat</h3>
      <label for="penerima_alamat_surat">Penerima dan Alamat Surat:</label>
      <textarea id="penerima_alamat_surat" name="penerima_alamat_surat" required></textarea>

      <label for="salam_pembuka">Salam Pembuka:</label>
      <textarea id="salam_pembuka" name="salam_pembuka" required></textarea>

      <label for="paragraf_pertama">Paragraf Pertama:</label>
      <textarea id="paragraf_pertama" name="paragraf_pertama"></textarea>

      <div>
        <h4>Tambahkan Nomor di Isi Surat (optional)</h4>
        <ol id="isi_nomor">
          <li>
            <input type="text" name="isi_nomor[]">
            <button type="button" class="add-icon" onclick="addIsiNomor()">+</button>
          </li>
        </ol>
        <input type="hidden" id="isi_nomor_data" name="isi_nomor_data" />
      </div>
      <div>
        <h4>Tambahkan Tabel di Isi Surat (optional)</h4>
        <table id="dynamic-table">
          <thead>
            <tr id="header-row">
              <!-- header cells will be added dynamically here -->
            </tr>
          </thead>
          <tbody>
            <!-- table rows will be added dynamically here -->
          </tbody>
        </table>
        <input type="hidden" id="tabel_data" name="tabel_data" />
        <!-- buttons to add/remove columns and rows -->
        <button id="add-column-btn">Add Column</button>
        <button id="remove-column-btn">Remove Column</button>
        <button id="add-row-btn">Add Row</button>
        <button id="remove-row-btn">Remove Row</button>
      </div>

      <label for="paragraf_kedua">Paragraf Kedua (Opsional):</label>
    <textarea id="paragraf_kedua" name="paragraf_kedua"></textarea>

    <label for="penutup">Penutup:</label>
    <textarea id="penutup" name="penutup"></textarea>
    </section>

    <section>
      <h3>Lampiran (optional)</h3>
      <label for="isi_lampiran">Isi Lampiran:</label>
      <textarea id="isi_lampiran" name="isi_lampiran"></textarea>
    </section>

    <button type="submit">Generate PDF</button>
  </form>

  <script>
    const table = document.getElementById('dynamic-table');
    const headerRow = document.getElementById('header-row');
    const tbody = table.tBodies[0];

    // initialize the table with a single header cell and row
    const headerCell = document.createElement('th');
    headerCell.contentEditable = 'true';
    headerRow.appendChild(headerCell);

    const row = document.createElement('tr');
    const cell = document.createElement('td');
    cell.contentEditable = 'true';
    row.appendChild(cell);
    tbody.appendChild(row);

    // add event listeners to the buttons
    document.getElementById('add-column-btn').addEventListener('click', () => {
      const newHeaderCell = document.createElement('th');
      newHeaderCell.contentEditable = 'true';
      newHeaderCell.innerHTML = `Header ${headerRow.cells.length + 1}`;
      headerRow.appendChild(newHeaderCell);

      Array.prototype.forEach.call(tbody.rows, (row) => {
        const newCell = document.createElement('td');
        newCell.contentEditable = 'true';
        newCell.innerHTML = `Cell ${row.cells.length + 1}`;
        row.appendChild(newCell);
      });
    });

    document.getElementById('remove-column-btn').addEventListener('click', () => {
      if (headerRow.cells.length > 1) {
        headerRow.removeChild(headerRow.lastChild);
        Array.prototype.forEach.call(tbody.rows, (row) => {
          row.removeChild(row.lastChild);
        });
      }
    });

    document.getElementById('add-row-btn').addEventListener('click', () => {
      const newRow = document.createElement('tr');
      Array.prototype.forEach.call(headerRow.cells, (headerCell, index) => {
        const newCell = document.createElement('td');
        newCell.contentEditable = 'true';
        newCell.innerHTML = `Cell ${index + 1}`;
        newRow.appendChild(newCell);
      });
      tbody.appendChild(newRow);
    });

    document.getElementById('remove-row-btn').addEventListener('click', () => {
      if (tbody.rows.length > 1) {
        tbody.removeChild(tbody.lastChild);
      }
    });

    // serialize the table data when the form is submitted
    document.querySelector('form').addEventListener('submit', (e) => {
        const table = document.getElementById('dynamic-table');
        const rows = table.rows;
        const data = [];

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.cells;
            const rowData = [];

            for (let j = 0; j < cells.length; j++) {
                rowData.push(cells[j].innerHTML);
            }

            data.push(rowData);
        }

        document.getElementById('tabel_data').value = JSON.stringify(data);

        const isiNomorList = document.getElementById('isi_nomor');
        const isiNomorValues = [];
        Array.prototype.forEach.call(isiNomorList.children, (li) => {
          isiNomorValues.push(li.children[0].value);
        });
        document.getElementById('isi_nomor_data').value = JSON.stringify(isiNomorValues);
    });

    function addIsiNomor() {
      var list = document.getElementById("isi_nomor");
      var li = document.createElement("li");
      li.innerHTML = "<input type='text' name='isi_nomor[]'><button type='button' class='add-icon' onclick='addIsiNomor()'>+</button>";
      list.appendChild(li);
    }

  </script>

</body>

</html>