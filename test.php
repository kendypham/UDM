<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>
<script>
   function handleFile(e) {
     //Get the files from Upload control
        var files = e.target.files;
        var i, f;
     //Loop through files
        for (i = 0, f = files[i]; i != files.length; ++i) {
            var reader = new FileReader();
            var name = f.name;
            reader.onload = function (e) {
                var data = e.target.result;

                var result;
                var workbook = XLSX.read(data, { type: 'binary' });
                
                var sheet_name_list = workbook.SheetNames;
                sheet_name_list.forEach(function (y) { /* iterate through sheets */
                    //Convert the cell value to Json
                    var roa = XLSX.utils.sheet_to_json(workbook.Sheets[y]);
                    if (roa.length > 0) {
                        result = roa;
                    }
                });
               //Get the first column first cell value
                alert(result[0].Column1);
            };
            reader.readAsArrayBuffer(f);
        }
    }

  //Change event to dropdownlist
  $(document).ready(function(){
    $('#files').change(handleFile);
  });
</script>

<input type="file" id="files" name="files"/>