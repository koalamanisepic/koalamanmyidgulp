<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Controller</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #222; color: white; padding: 20px; }
        .btn { padding: 15px 25px; font-size: 18px; margin: 8px; border: none; cursor: pointer; border-radius: 5px; font-weight: bold; }
        
        /* Direction Styles */
        .dir-btn { background: #555; color: white; min-width: 120px; }
        .dir-active { background: #2196F3; color: white; box-shadow: 0 0 15px #2196F3; }
        
        /* Gear Styles */
        .gear-btn { background: #444; color: #aaa; min-width: 80px; }
        .gear-active { background: #4CAF50; color: white; box-shadow: 0 0 15px #4CAF50; }
        
        .stop { background: #f44336; color: white; width: 80%; max-width: 300px; margin-top: 25px; }
        .status-box { margin: 20px auto; padding: 10px; max-width: 300px; background: #333; border-radius: 5px; border: 1px solid #444; }
        .braking { color: #ff9800; font-size: 14px; margin-top: 10px; display: none; font-weight: bold; }
    </style>
</head>
<body>

    <h1>🚂 Railking Controller</h1>
    
    <div class="status-box">
        <div>Direction: <strong><span id="txtDir">STOPPED</span></strong></div>
        <div>Current Gear Target: <strong><span id="txtSpeed">0</span></strong></div>
        <div id="brakeMsg" class="braking">⚠️ Automatically braking to speed 95 before reversing...</div>
    </div>

    <!-- Direction Selection -->
    <h3>1. Select Direction</h3>
    <button id="btnFwd" class="btn dir-btn" onclick="setDirection(1)">◀ Forward</button>
    <button id="btnRev" class="btn dir-btn" onclick="setDirection(2)">Reverse ▶</button>

    <!-- Gear Selection -->
    <h3>2. Select Gear (Speed)</h3>
    <button id="btnG1" class="btn gear-btn" onclick="setGear(95, 1)">Gear 1 (95)</button>
    <button id="btnG2" class="btn gear-btn" onclick="setGear(150, 2)">Gear 2 (150)</button>
    <button id="btnG3" class="btn gear-btn" onclick="setGear(200, 3)">Gear 3 (200)</button>
    
    <br>
    <button class="btn stop" onclick="emergencyStop()">🛑 STOP</button>

    <script>
        let currentDirection = 0; // 0=Stop, 1=Fwd, 2=Rev
        let currentSpeed = 0;
        let currentGear = 0;
        let isBraking = false;

        function setDirection(dir) {
            if (isBraking) return; // Ignore input while automatic sequence runs

            // AUTOMATIC SAFETY CHECK: If changing to Reverse while moving forward at higher speeds
            if (dir === 2 && currentDirection === 1 && currentSpeed > 95) {
                isBraking = true;
                document.getElementById('brakeMsg').style.display = 'block';
                
                // 1. Force speed drop to Gear 1 (95) instantly, but keep direction as Forward for now
                currentSpeed = 95;
                currentGear = 1;
                updateGearUI(1, 95);
                transmitCommand();

                // 2. Wait 1000ms (1 second) for train momentum to slow down, then switch to Reverse
                setTimeout(() => {
                    currentDirection = 2;
                    updateDirectionUI(2);
                    transmitCommand();
                    
                    document.getElementById('brakeMsg').style.display = 'none';
                    isBraking = false;
                }, 1000); 
                
                return; 
            }

            // Normal immediate execution if already slow, stopped, or just changing gears
            currentDirection = dir;
            updateDirectionUI(dir);

            if (currentSpeed > 0) {
                transmitCommand();
            }
        }

        function setGear(speedValue, gearNum) {
            if (isBraking) return;

            if (currentDirection === 0) {
                currentDirection = 1; 
                updateDirectionUI(1);
            }

            currentSpeed = speedValue;
            currentGear = gearNum;
            updateGearUI(gearNum, speedValue);
            transmitCommand();
        }

        function updateDirectionUI(dir) {
            document.getElementById('btnFwd').className = 'btn dir-btn' + (dir === 1 ? ' dir-active' : '');
            document.getElementById('btnRev').className = 'btn dir-btn' + (dir === 2 ? ' dir-active' : '');
            document.getElementById('txtDir').innerText = (dir === 1 ? 'FORWARD' : (dir === 2 ? 'REVERSE' : 'STOPPED'));
        }

        function updateGearUI(gearNum, speedValue) {
            document.getElementById('btnG1').className = 'btn gear-btn' + (gearNum === 1 ? ' gear-active' : '');
            document.getElementById('btnG2').className = 'btn gear-btn' + (gearNum === 2 ? ' gear-active' : '');
            document.getElementById('btnG3').className = 'btn gear-btn' + (gearNum === 3 ? ' gear-active' : '');
            document.getElementById('txtSpeed').innerText = speedValue;
        }

        function emergencyStop() {
            currentDirection = 0;
            currentSpeed = 0;
            currentGear = 0;
            isBraking = false;
            
            updateDirectionUI(0);
            updateGearUI(0, 0);
            document.getElementById('brakeMsg').style.display = 'none';
            
            transmitCommand();
        }

        function transmitCommand() {
            fetch(`update_command.php?dir=${currentDirection}&spd=${currentSpeed}`)
            .then(response => response.text())
            .then(data => console.log("Sent: " + data));
        }
    </script>
</body>
</html>