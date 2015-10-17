using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Runtime.InteropServices.WindowsRuntime;
using Windows.Foundation;
using Windows.Foundation.Collections;
using Windows.UI;
using Windows.UI.Xaml;
using Windows.UI.Xaml.Controls;
using Windows.UI.Xaml.Controls.Primitives;
using Windows.UI.Xaml.Data;
using Windows.UI.Xaml.Input;
using Windows.UI.Xaml.Media;
using Windows.UI.Xaml.Navigation;
using GrovePi;
using GrovePi.Sensors;
using GrovePi.I2CDevices;
using MySql.Data.MySqlClient;
using System.Diagnostics;

// The Blank Page item template is documented at http://go.microsoft.com/fwlink/?LinkId=402352&clcid=0x409

namespace busmass
{

    /// <summary>
    /// An empty page that can be used on its own or navigated to within a Frame.
    /// </summary>
    public sealed partial class MainPage : Page
    {
        /* Raspi Hardware */
        private readonly IBuildGroveDevices _deviceFactory = DeviceFactory.Build;
        private readonly IRgbLcdDisplay Display;
        private readonly IButtonSensor Button;
        private readonly ILed BlueLed;
        private readonly SolidColorBrush Blue;
        private readonly ILed GreenLed;
        private readonly SolidColorBrush Green;
        private readonly ILed RedLed;
        private readonly SolidColorBrush Red;
        private readonly SolidColorBrush Gray;
        private readonly ILightSensor LightSensor;

        /* Database */
        MySqlConnection db;
        private double CurrentWeight;
        private int CurrentLine;

        public MainPage()
        {
            this.InitializeComponent();

            // initialise database
            try
            {
                db = new MySqlConnection("server=us-cdbr-azure-central-a.cloudapp.net;uid=b0a941f833069a;pwd=<pass>;database=as_eb778c54b5aa1fa;SslMode=None;charset=utf8;");
                db.Open();
            }
            catch (Exception e)
            {
                Debug.WriteLine("Failed to connect to db : " + e.Message);
            }

            // colors
            Blue = new SolidColorBrush(Colors.Blue);
            Green = new SolidColorBrush(Colors.Green);
            Red = new SolidColorBrush(Colors.Red);
            Gray = new SolidColorBrush(Colors.Gray);

            // initialise hardware
            _deviceFactory = DeviceFactory.Build;
            Display = _deviceFactory.RgbLcdDisplay();
            Button = _deviceFactory.ButtonSensor(Pin.DigitalPin8);
            BlueLed = _deviceFactory.Led(Pin.DigitalPin2);
            GreenLed = _deviceFactory.Led(Pin.DigitalPin3);
            RedLed = _deviceFactory.Led(Pin.DigitalPin4);
            LightSensor = _deviceFactory.LightSensor(Pin.AnalogPin2);

            // line info
            CurrentWeight = LightSensor.SensorValue();
            CurrentLine = 2;
            dbSet(CurrentLine);

            // update UI
            WeightText.Text = CurrentWeight.ToString();

            // LED tests
            DispatcherTimer time = new DispatcherTimer();
            time.Interval = TimeSpan.FromMilliseconds(5);
            time.Tick += tick;
            time.Start();

            // light sensor to simulate weight
            DispatcherTimer weightUpdater = new DispatcherTimer();
            weightUpdater.Interval = TimeSpan.FromSeconds(30);
            weightUpdater.Tick += updateWeight;
            weightUpdater.Start();
        }

        public void updateWeight(object sender, object e)
        {
            try
            {
                CurrentWeight = LightSensor.SensorValue();
                dbSet(CurrentLine);
            }
            catch (Exception ex)
            {
                Debug.WriteLine("Failed to update weight : " + ex.Message);
            }
        }

        public void tick(object sender, object e)
        {
            try
            {
                Display.SetText(CurrentWeight.ToString()).SetBacklightRgb(0, 255, 255);
                WeightText.Text = CurrentWeight.ToString();
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex.Message);
            }
            try
            {
                if (Button.CurrentState == SensorStatus.On)
                {
                    BlueLed.ChangeState(SensorStatus.On);
                    blueledcircle.Fill = Blue;
                    GreenLed.ChangeState(SensorStatus.On);
                    greenledcircle.Fill = Green;
                    RedLed.ChangeState(SensorStatus.On);
                    redledcircle.Fill = Red;
                }
                else
                {
                    BlueLed.ChangeState(SensorStatus.Off);
                    blueledcircle.Fill = Gray;
                    GreenLed.ChangeState(SensorStatus.Off);
                    greenledcircle.Fill = Gray;
                    RedLed.ChangeState(SensorStatus.Off);
                    redledcircle.Fill = Gray;
                }
            }
            catch (Exception ex2)
            {
                Debug.WriteLine(ex2.Message);
            }
        }

        // update database with weight info for a given line
        public void dbSet(int lineNumber)
        {
            try
            {
                string query = "UPDATE bus SET poids = '" + this.CurrentWeight + "' WHERE id = '" + lineNumber + "'";
                MySqlCommand cmd = new MySqlCommand(query, db);
                cmd.ExecuteNonQuery();
            }
            catch (Exception e)
            {
                Debug.WriteLine("Failed to insert data into db..." + e.Message);
            }
        }

        public void dispose()
        {
            Display.SetText("Bye!");
            db.Close();
        }
    }
}
