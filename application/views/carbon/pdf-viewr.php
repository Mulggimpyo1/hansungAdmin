<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>PDF Viewer</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
    body {
      margin: 0;
      padding: 0;
    }

    #pdf-viewer {
      width: 100%;
      height: calc(100% - 60px);
      margin-top: 60px;
    }

    header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      background-color: #fff;
      z-index: 1;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }

    header button {
      font-size: 20px;
      padding: 10px;
      background-color: transparent;
      border: none;
      cursor: pointer;
    }

    header button:hover {
      background-color: #f4f4f4;
    }

    header span {
      font-size: 18px;
      margin: 0 20px;
    }



    </style>
  </head>
  <body>
    <header>
      <button id="prev-page" onclick="onPrevPage()">&#8249;</button>
      <span><span id="page_num"></span> / <span id="page_count"></span></span>
      <button id="next-page" onclick="onNextPage()">&#8250;</button>
      <button class="close-button" id="close-button">&#x2716;</button>
    </header>
    <canvas id="pdf-viewer"></canvas>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js"></script>
    <script>
    var closeButton = document.getElementById("close-button");

    closeButton.addEventListener("click", function() {
      window.close();
    });
      // PDF 파일을 로드할 URL
      var url = '/upload/board/{pdf}';

      // PDF.js 초기화
      pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js';

      // PDF.js 컨트롤러 생성
      var pdfDoc = null,
          pageNum = 1,
          pageRendering = false,
          pageNumPending = null,
          scale = 1.5,
          canvas = document.getElementById('pdf-viewer'),
          ctx = canvas.getContext('2d');

      // 페이지 렌더링 함수
      function renderPage(num) {
        pageRendering = true;

        // PDF.js로부터 페이지 가져오기
        pdfDoc.getPage(num).then(function(page) {
          var viewport = page.getViewport({scale: scale});
          canvas.height = viewport.height;
          canvas.width = viewport.width;

          // 페이지 그리기
          var renderContext = {
            canvasContext: ctx,
            viewport: viewport
          };
          var renderTask = page.render(renderContext);

          // 페이지 렌더링 완료 처리
          renderTask.promise.then(function() {
            pageRendering = false;
            if (pageNumPending !== null) {
              // 보류 중인 페이지 렌더링
              renderPage(pageNumPending);
              pageNumPending = null;
            }
          });
        });

        // 페이지 번호 업데이트
        $('#page_num').text(num);
      }

      // 다음 페이지 로드
      function queueRenderPage(num) {
        if (pageRendering) {
          pageNumPending = num;
        } else {
          renderPage(num);
        }
      }

      // 이전 페이지
      function onPrevPage() {
        if (pageNum <= 1) {
          return;
        }
        pageNum--;
        queueRenderPage(pageNum);
      }

      // 다음 페이지
      function onNextPage() {
        if (pageNum >= pdfDoc.numPages) {
          return;
        }
        pageNum++;
        queueRenderPage(pageNum);
      }

      // PDF 파일 로드
      pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
        pdfDoc = pdfDoc_;
        var numPages = pdfDoc.numPages;

        // 페이지 수 업데이트
        $('#page_count').text(numPages);

        // 첫 페이지 렌더링
        renderPage(pageNum);
      });

      </script>
    </body>
    </html>
