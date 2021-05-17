var barcodeDone
function setupLiveReader(resultElement) {
  var closeButton = $(
    '<button class="button button-primary uk-width-1-1" onclick="stopBarcodeReader()">Luk scanning</button>'
  )
  var container = document.createElement('div')
  var buttondiv = document.createElement('div')
  var barcodeResult = false

  container.style.position = 'absolute'
  container.style.width = '100%'
  container.style.height = '100%'
  container.style.left = '0'
  container.style.top = '0'
  container.style.background = '#474C55'
  container.id = 'barcode-reader'

  buttondiv.style.position = 'absolute'
  buttondiv.id = 'button'

  var canvas = document.createElement('canvas')
  var video = document.createElement('video')
  var context = canvas.getContext('2d')

  canvas.style.position = 'absolute'

  buttondiv.appendChild(closeButton[0])
  container.appendChild(canvas)

  
  document.body.appendChild(container)
  document.body.appendChild(buttondiv)

  const constraints = {
    audio: false,
    video: {
      facingMode: 'environment'
    }
  }

  navigator.mediaDevices
    .getUserMedia(constraints)
    .then(function(stream) {
      window.currentStream = stream.getTracks()[0]
      video.width = 320

      BarcodeScanner.init()
      BarcodeScanner.streamCallback = function(result) {
        console.log('barcode detected, stream will stop')
        console.log(result[0].Value);
        console.log(result[0].Value.toString().length);
        
        //$("#code").text(result[0].Value);
        if(result[0].Value.toString().length == 13){
          barcodeResult = true
          barcodeDone = result[0].Value;
          console.log(barcodeResult);
        }


        BarcodeScanner.StopStreamDecode()
        stopBarcodeReader()
      }

      video.setAttribute('autoplay', '')
      video.setAttribute('playsinline', '')
      video.setAttribute('style', 'width: 100%;height: 100%')
      video.srcObject = stream
      container.appendChild(video)
      video.onloadedmetadata = function(e) {
        var canvasSetting = {
          x: 50,
          y: 55,
          width: 200,
          height: 25
        }
        var rect = video.getBoundingClientRect()
        console.log(rect.height)
        canvas.style.height = rect.height + 'px'
        canvas.style.width = rect.width + 'px'
        canvas.style.top = rect.top + 'px'
        canvas.style.left = rect.left + 'px'
        const overlayColor = 'rgba(71, 76, 85, .9)'
        context.fillStyle = overlayColor
        context.fillRect(0, 0, rect.width, rect.height)
        context.clearRect(
          canvasSetting.x,
          canvasSetting.y,
          canvasSetting.width,
          canvasSetting.height
        )
        context.strokeStyle = '#ff671f'
        context.strokeRect(
          canvasSetting.x,
          canvasSetting.y,
          canvasSetting.width,
          canvasSetting.height
        )
        video.play()
        BarcodeScanner.DecodeStream(video)
      }
    })
    .catch(function(err) {
      console.log(err)
    })
}

function stopBarcodeReader() {
  var barcodeContainer = document.getElementById('barcode-reader')
  document.body.removeChild(barcodeContainer)
  document.body.removeChild(document.getElementById('button'))

  window.currentStream.stop()

  scanCallback(barcodeDone)
}
