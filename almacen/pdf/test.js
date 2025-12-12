/**
 * Created by usuario on 22/09/2016.
 */
function printPdfTest() {
    var docDefinition = {
        content: [
            'First paragraph',
            'Another paragraph'
        ]
    };
    pdfMake.createPdf(docDefinition).open('test.pdf');
}