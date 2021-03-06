<?php
/*
        Vot.Ar: a bad election. Presentation for the Banco Frances, dic 2015
        by HacKan | Ivan A. Barrera Oro
        Licence CC BY-SA v4.0: http://creativecommons.org/licenses/by-sa/4.0/
        Feel free to share!!
*/

error_reporting(E_ALL);

/**
 * Defines if Overview will be shown if no parameter is passed through GET
 */
define('SHOW_OVERVIEW', false);

class Position
{
  /**
   * Coordinates (data-...)
   */
  private $_x, $_y, $_z;
  /**
   * Angles (data-rotate-...)
   */
  private $_alpha, $_theta, $_phi;
  /**
   * Overview position (could be automated)
   */
  private $_overviewX, $_overviewY, $_overviewS;

  function __construct()
  {
    $this->reset();
  }

  /**
   * Sets the Overview coordinates. Values can be negative.
   *
   * @param array $coord
   * an array of coordinates such as
   * [ "x" => 1, "y" => 2, "s" => 3] or [1, 2, 3]
   * Note that S is the Scale.
   * It's not necessary to set all three elements.
   * Elements not set will be omitted, keeping it's current value!.
   *
   */
  public function set_overview($overview)
  {
    if (is_array($overview)) {
      $this->_overviewX = array_key_exists("x", $overview)
                                          ? $overview["x"]
                                          : (array_key_exists(0, $overview)
                                                            ? $overview[0]
                                                            : $this->_overviewX
                                            );
      $this->_overviewY = array_key_exists("y", $overview)
                                          ? $overview["y"]
                                          : (array_key_exists(1, $overview)
                                                            ? $overview[1]
                                                            : $this->_overviewY
                                            );
      $this->_overviewS = array_key_exists("s", $overview)
                                          ? $overview["s"]
                                          : (array_key_exists(2, $overview)
                                                            ? $overview[2]
                                                            : $this->_overviewS
                                            );
    }
  }

  /**
   * This method calculates the overview coordinates based on the
   * currently set coords, asuming these are the final ones, and that
   * the first ones are [0,0]
   */
  public function autoset_overview()
  {
    $this->_overviewX =  (int) ($this->_x / 2);
    $this->_overviewY =  (int) ($this->_y / 2);
    // how can I calculate this? I think it can be done w/ the
    // screen resolution
    //$this->_overviewS = 32
  }

  /**
   * Sets the coordinates to a given value. Values can be negative.
   *
   * @param array|numeric $coord [optional]
   * an array of coordinates such as
   * [ "x" => 1, "y" => 2, "z" => 3] or [1, 2, 3]
   * It's not necessary to set all three elements.
   * Elements not set will be omitted, keeping it's current value!.
   * It can also be a numeric, and if so, it will be considered for
   * only X.
   */
  public function set_coord($coord)
  {
    if (is_array($coord)) {
      $this->_x = array_key_exists("x", $coord)
                                  ? $coord["x"]
                                  : (array_key_exists(0, $coord)
                                                    ? $coord[0]
                                                    : $this->_x
                                    );
      $this->_y = array_key_exists("y", $coord)
                                  ? $coord["y"]
                                  : (array_key_exists(1, $coord)
                                                    ? $coord[1]
                                                    : $this->_y
                                    );
      $this->_z = array_key_exists("z", $coord)
                                  ? $coord["z"]
                                  : (array_key_exists(2, $coord)
                                                    ? $coord[2]
                                                    : $this->_z
                                    );
    } elseif (is_numeric($coord)) {
      $this->_x = $coord;
    }
  }

  /**
   * Sets the angles to a given value. Values can be negative.
   *
   * @param array|numeric $angle [optional]
   * an array of angles such as
   * [ "alpha" => 1, "theta" => 2, "phi" => 3] or [1, 2, 3]
   * It's not necessary to set all three elements.
   * Elements not set will be omitted, keeping it's current value!.
   * It can also be a numeric, and if so, it will be considered for
   * only alpha.
   */
  public function set_angle($angle)
  {
    if (is_array($angle)) {
      $this->_alpha = array_key_exists("alpha", $angle)
                                      ? $angle["alpha"]
                                      : (array_key_exists(0, $angle)
                                                        ? $angle[0]
                                                        : $this->_alpha
                                        );
      $this->_theta = array_key_exists("theta", $angle)
                                      ? $angle["theta"]
                                      : (array_key_exists(1, $angle)
                                                        ? $angle[1]
                                                        : $this->_theta
                                        );
      $this->_phi = array_key_exists("phi", $angle)
                                      ? $angle["phi"]
                                      : (array_key_exists(2, $angle)
                                                        ? $angle[2]
                                                        : $this->_phi
                                        );
    } elseif (is_numeric($angle)) {
      $this->_alpha = $angle;
    }
  }

  /**
   * Sets the coordinates and angles to a given value. Values can
   * be negative.
   *
   * @param array|numeric $coord [optional]
   * an array of coordinates such as
   * [ "x" => 1, "y" => 2, "z" => 3] or [1, 2, 3]
   * It's not necessary to set all three elements.
   * Elements not set will be omitted, keeping it's current value!.
   * It can also be a numeric, and if so, it will be considered for only X.
   *
   * @param array|numeric $angle [optional]
   * an array of angles such as
   * [ "alpha" => 1, "theta" => 2, "phi" => 3] or [1, 2, 3]
   * It's not necessary to set all three elements.
   * Elements not set will be omitted, keeping it's current value!.
   * It can also be a numeric, and if so, it will be considered for
   * only alpha.
   */
  public function set($coord = NULL, $angle = NULL)
  {
    $this->set_coord($coord);
    $this->set_angle($angle);
  }

  /**
   * Sets coords to 0.
   */
  public function reset_coord()
  {
    $this->set_coord([0, 0, 0]);
  }

  /**
   * Sets angles to 0.
   */
  public function reset_angle()
  {
    $this->set_angle([0, 0, 0]);
  }

  /**
   * Sets overview to [0, 0, 0].
   */
  private function reset_overview()
  {
    $this->set_overview([0, 0, 0]);
  }

  /**
   * Sets coords and angles to 0.
   */
  public function reset()
  {
    $this->reset_coord();
    $this->reset_angle();
    $this->reset_overview();
  }


  /**
   * Get the coordinates
   *
   * @return array An array of coordinates
   */
  public function get_coord()
  {
    return [$this->_x, $this->_y, $this->_z];
  }

  /**
   * Get the angles
   *
   * @return array An array of angles
   */
  public function get_angle()
  {
    return [$this->_alpha, $this->_theta, $this->_phi];
  }

  /**
   * Shifts the coordinates with a given value.  This means that it adds
   * the value to current coords.  Values can be negative.
   *
   * @param array|numeric $delta an array of coordinates such as
   * [ "x" => 1, "y" => 2, "z" => 3] or [1, 2, 3]
   * It's not necessary to set all three elements.
   * It can also be a numeric, and if so, it will be considered for
   * only X.
   */
  public function shift_coord($delta)
  {
    if (is_array($delta)) {
      $this->_x += array_key_exists("x", $delta)
                                  ? $delta["x"]
                                  : (array_key_exists(0, $delta)
                                                    ? $delta[0]
                                                    : 0
                                    );
      $this->_y += array_key_exists("y", $delta)
                                  ? $delta["y"]
                                  : (array_key_exists(1, $delta)
                                                    ? $delta[1]
                                                    : 0
                                    );
      $this->_z += array_key_exists("z", $delta)
                                  ? $delta["z"]
                                  : (array_key_exists(2, $delta)
                                                    ? $delta[2]
                                                    : 0
                                    );
    } elseif (is_numeric($delta)) {
      $this->_x += $delta;
    }
  }

  /**
   * Shifts the angles with a given value.  This means that it adds
   * the value to current angles.  Values can be negative.
   *
   * @param array|numeric $delta an array of angles such as
   * [ "alpha" => 1, "theta" => 2, "" => 3] or [1, 2, 3]
   * It's not necessary to set all three elements.
   * It can also be a numeric, and if so, it will be considered for
   * only alpha.
   */
  public function shift_angle($delta)
  {
    if (is_array($delta)) {
      $this->_alpha += array_key_exists("alpha", $delta)
                                      ? $delta["alpha"]
                                      : (array_key_exists(0, $delta)
                                                        ? $delta[0]
                                                        : 0
                                        );
      $this->_theta += array_key_exists("theta", $delta)
                                      ? $delta["theta"]
                                      : (array_key_exists(1, $delta)
                                                        ? $delta[1]
                                                        : 0
                                        );
      $this->_phi += array_key_exists("phi", $delta)
                                      ? $delta["phi"]
                                      : (array_key_exists(2, $delta)
                                                        ? $delta[2]
                                                        : 0
                                        );
    } elseif (is_numeric($delta)) {
      $this->_alpha += $delta;
    }
  }

  /**
   * Shifts the coords and/or angles.
   * Equal as calling shift_coord() and shift_angle().
   *
   * @param array|numeric $delta_coord [optional]
   * @param array|numeric $delta_angle [optional]
   */
  public function shift($delta_coord = NULL, $delta_angle = NULL)
  {
    $this->shift_coord($delta_coord);
    $this->shift_angle($delta_angle);
  }

  /**
   * Prints the required text to set the coordinates and angles
   * for impress.js
   */
  public function printc()
  {
    echo 'data-x="' . $this->_x
            . '" data-y="' . $this->_y
            . '" data-z="' . $this->_z . '"';

    echo ' ';

    echo 'data-rotate-x="' . $this->_alpha
            . '" data-rotate-y="' . $this->_theta
            . '" data-rotate-z="' . $this->_phi . '"';
  }

  /**
   * Combination of calling: shift() and printc().
   *
   * @param array|numeric $delta_coord [optional]
   * @param array|numeric $delta_angle [optional]
   */
  public function shiftprint($delta_coord = NULL, $delta_angle = NULL)
  {
    $this->shift($delta_coord, $delta_angle);
    $this->printc();
  }

  public function print_overview()
  {
    echo '<div id="overview" class="step" '
            . 'data-x="' . $this->_overviewX . '" '
            . 'data-y="' . $this->_overviewY . '" '
            . 'data-scale="' . $this->_overviewS . '"'
            . '></div>';
  }
}

function get_opt($opt)
{
  return (array_key_exists($opt, $_GET)
                          ? $_GET[$opt]
                          : ''
          );
}

$show_overview = (get_opt('overview') != '')
                  ? true
                  : SHOW_OVERVIEW;

$pos = new Position;
$pos->set_overview(["s" => 50]);
?>
<!DOCTYPE html>
<html lang="es">
<!--
  Vot.Ar: una mala eleccion. Presentaci&oacute;n para el Banco Frances, dic 2015
  por HacKan | Ivan A. Barrera Oro
  Licencia CC BY-SA v4.0: http://creativecommons.org/licenses/by-sa/4.0/
  Compartilo!!

  v201511120

  Note: vulnerability level by DREAD:
                                  {D, R, E, A, D} = [0, 10]
  Given any vuln/threat t:
                                  t ∈ {low,med,high,crit} ⊂ R
                                  ∧ 10>crit>high>med>low>0
                                  ∧ 0 < low < 2.5
                                  ∧ med < 5
                                  ∧ high < 7.5
                                  ∧ crit < 10
  => t=(D+R+E+A+D)/5
-->
<head>
  <meta charset="utf-8">

	<title>Vot.Ar: una mala elecci&oacute;n</title>
  <meta name="author" content="Iv&aacute;n A. Barrera Oro" />
  <meta name="description" content="Vot.Ar: una mala elecci&oacute;n. Presentaci&oacute;n para el Banco Frances, dic 2015" />
  <link rel="icon" href="img/logo.png" sizes="196x196" type="image/png" />

  <link href="css/reset.css" rel="stylesheet" />
  <link href="css/presentation.css" rel="stylesheet" />
  <link href="font/opensans.css" rel="stylesheet" />
  <link href="font/oswald.css" rel="stylesheet" />
  <link href="font/anonymouspro.css" rel="stylesheet" />

  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="apple-mobile-web-app-capable" content="yes" />

  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@hackancuba" />
  <meta name="twitter:title" content="Vot.Ar: una mala elecci&oacute;n" />
  <meta name="twitter:description" content="Presentaci&oacute;n para el Banco Frances, dic 2015" />
  <meta name="twitter:image" content="img/logo.png" />

  <meta property="og:title" content="Vot.Ar: una mala elecci&oacute;n" />
  <meta property="og:description" content="Presentaci&oacute;n para el Banco Frances, dic 2015" />
  <meta property="og:locale" content="es_AR" />
</head>

<body class="impress-not-supported">

	<div class="fallback-message">
    <p>Tu navegador <em>no soporta las caracter&iacute;sticas requeridas</em> por esta presentaci&oacute;n, por lo que se mostrar&aacute; una versi&oacute;n simplificada.</p>
    <p>Para obtener una mejor experiencia, utiliza <strong>Firefox</strong>, <strong>Chrome</strong> o <strong>Safari</strong>.</p>
	</div>

	<div id="impress">
    <!-- welcome -->
    <div id="title" class="step anim" <?php $pos->printc(); ?> data-scale="3">
      <h1 class="centered">Vot.Ar: una mala elecci&oacute;n</h1>
      <h3>Presentaci&oacute;n sobre el sistema <i class="flag-blue">Vot.Ar</i> (o BUE), su HW, SW y Vulnerabilidades.</h3>
      <br /><br />
      <p>Y tambi&eacute;n, un poco sobre <i>voto electr&oacute;nico</i>.</p>
      <p class="footnote"><a class="link-shadow" target="_blank" href="https://twitter.com/hashtag/VotArUnaMalaEleccion">#VotArUnaMalaEleccion</a></p>
		</div>
    <!-- -->

    <!-- authors -->
    <div id="authors" class="step" <?php $pos->shift(["y" => 4000], -30); $pos->printc(); ?> data-scale="10">
      <p>Presentador: <a class="link" target="_blank" href="https://twitter.com/hackancuba">Iv&aacute;n (HacKan) A. Barrera Oro</a>.</p>
      <p>Colaboradores:
        <a class="link" target="_blank" href="https://twitter.com/famato">Francisco Amato</a>,
        <a class="link" target="_blank" href="https://twitter.com/FViaLibre">Enrique Chaparro</a>,
        <a class="link" target="_blank" href="https://twitter.com/SDLerner">Sergio Demian Lerner</a>,
        <a class="link" target="_blank" href="https://twitter.com/ortegaalfredo">Alfredo Ortega</a>,
        <a class="link" target="_blank" href="https://twitter.com/julianor">Juliano Rizzo</a>,
        <a class="link" target="_blank" href="https://www.onapsis.com/blog/author/fernando-russ">Fernando Russ</a>,
        <a class="link" target="_blank" href="https://twitter.com/mis2centavos">Javier Smaldone</a>,
        <a class="link" target="_blank" href="https://twitter.com/nicowaisman">Nicolas Waisman</a>.
      </p>
      <p class="footnote">Y la gente de internet...</p>
    </div>
    <?php $pos->shift(8500); ?>
    <!-- - -->

    <!-- -how did we do it? -->
    <div class="step" <?php $pos->reset_angle(); $pos->shiftprint(["z" => -300], -40); ?> data-scale="1">
      <h2>&iquest;C&oacute;mo realizamos nuestra investigaci&oacute;n?</h2>
      <ul>
        <li>Cerca de una semana de trabajo (en principio).</li>
        <li><strong>No oficial</strong>: ninguna asistencia fue proporcionada por la empresa ni el gob.</li>
			</ul>
		</div>
    <div class="step" <?php $pos->shiftprint(["y"=>"730"]); ?> data-scale="1">
      <ul>
        <li>Yendo a puntos de consulta p&uacute;blicos para tener acceso a m&aacute;quinas y boletas.</li>
      </ul>
      <div class="centered"><img src="img/consultation-point.jpg" alt="Public constultation point" width="533" height="300" /></div>
    </div>

    <div class="step" <?php $pos->reset_angle(); $pos->shiftprint([0, 650, -400]); ?> data-scale="1">
      <ul>
        <li>Construyendo algunos dispositivos:
        <ul>
          <li>lector de boletas</li>
          <li>quemador de boletas</li>
          <li>RFID jammer</li>
        </ul>
        (algunos funcionaron, otros no)
        </li>
        <li>Mucha investigaci&oacute;n en internet (<em>gracias</em> al c&oacute;digo fuente y fotos filtradas)</li>
        <li>Gran esfuerzo</li>
      </ul>
    </div>
    <!-- - -->
    <!-- -->

    <!-- about vot.ar, brief desc -->
		<div class="step anim" <?php $pos->reset_angle(); $pos->shiftprint([0, 1050, 400]); ?> data-scale="1">
      <p><strong>Vot.Ar</strong> o <strong>BUE</strong> (Boleta &Uacute;nica Electr&oacute;nica), hecho por el Grupo MSA, es un sistema de voto electr&oacute;nico que cuenta con dos elementos principales:</p>
      <ul>
              <li>La m&aacute;quina emisora/contadora de votos</li>
              <li>La boleta</li>
      </ul>
      <br /><br /><br />
      <p><b class="scaling pastel-red">&iquest;Su vulnerabilidad m&aacute;s evidente?</b></p>
      <p class="footnote pastel-red">entre otras...</p>
    </div><!-- +(0,0,0) -->
		<div class="step hidden" <?php $pos->printc(); ?> data-scale="1">
      <div class="facepalm">
        <div class="overlay-img-txt txt-tiny pale-yellow">
          <img src="img/facepalm.jpg" alt="facepalm" width="300" height="225" />
          <span>&iexcl;Est&aacute; basado en RFID!</span>
		    </div>
		  </div>
		</div>
		<!-- -->

		<!-- israel case -->
    <div class="step hidden" <?php $pos->shiftprint([1100], ["theta" => -25]); ?> data-scale="1">
			<p>&iquest;Por qu&eacute; usar RFID es tan mala idea?</p>
			<img src="img/evoting-rfid.jpg" alt="e-voting rfid" width="1050" height="625" />
		</div>
		<!-- -->

		<!-- some details  -->
		<div id="req" class="step anim" <?php $pos->reset_angle(); $pos->shiftprint(["y" => 1100]); ?> data-scale="1">
		  <h2>Requerimientos de Vot.Ar (seg&uacute;n su patente y la Ley)</h2>
				<ol>
		      <li><strong>Universal</strong>*</li>
		      <li><strong>Igual</strong>*</li>
		      <li class="pastel-red"><strong>Secreto</strong>*</li>
		      <li><strong>Obligatorio</strong>*</li>
		      <li>Libre</li>
		      <li class="pastel-red">Un voto por elector</li>
				</ol>
		  <p class="footnote">* Derechos Constitucionales</p>
		</div>

    <div class="step" <?php $pos->shiftprint(["y" => 1000], ["theta" => 10]); ?> data-scale="1">
      <h2>Cosas a tener en cuenta respecto de Vot.Ar</h2>
		    <ul>
          <li>HW y SW completamente cerrado (<em>black box</em>).</li>
          <li>Absolutamente nada de documentaci&oacute;n p&uacute;blica: &iexcl;as&iacute; y todo los creadores dicen que es c&oacute;digo abierto!</li>
          <li>M&aacute;s de <strong>7 a&ntilde;os de desarrollo</strong>:
		        <ul>
              <li>Usado en Salta (y auditado all&iacute;)</li>
              <li>Recientemente usado en las capitales de Chaco y Neuqu&eacute;n</li>
		        </ul>
          </li>
		    </ul>
		</div>

    <div class="step" <?php $pos->shiftprint([1400, 115], ["theta" => 10]); ?> data-scale="1">
		  <ul>
        <li>2 auditorias oficiales al momento del informe (junio/julio 2015):
		      <ul>
            <li>Prof. Righetti, FCEN, UBA: OAT 03/15
            <br /><strong>Conclusi&oacute;n</strong>: <em>algunos inconvenientes, pero ok</em>.</li>
            <li>Departamento de Inform&aacute;tica, ITBA: DVT 56-504
            <br /><strong>Conclusi&oacute;n</strong>: <em>inconcluyente, recomendaciones dadas</em>.</li>
		      </ul>
        </li>
		  </ul>
		</div>

    <div class="step" <?php $pos->shiftprint([-1400, 750], ["theta" => -10]); ?> data-scale="1">
      <ul>
        <li>&iexcl;Una <strong>grave falla de seguridad</strong> deja al descubierto los <em>certificados SSL</em> empleados para asegurar la transmisi&oacute;n de resultados!</li>
        <li>Un programador independiente, <a href="https://twitter.com/_joac" class="link">Joaqu&iacute;n Sorianello</a>, reporta esta falla a la empresa, solo para ser <strong>allanado por la polic&iacute;a dos d&iacute;as antes de los comicios y por la tarde/noche</strong> (la causa a&uacute;n est&aacute; en curso).</li>
      </ul>
    </div>

    <div class="step" <?php $pos->shiftprint(1400, ["theta" => 10]); ?> data-scale="1">
      <ul>
        <li>Asimismo, hackeos independientes ocurren, provocando la fuga de datos personales de los t&eacute;cnicos de la empresa, motivo por el cual una Jueza decide <a href="http://pastebin.com/gHC89Mh6" class="link-shadow">bloquear</a> el sitio <a class="link" href="https://justpaste.it">justpaste.it</a> donde resid&iacute;a esta informaci&oacute;n.</li>
      </ul>
		</div>

		<!-- -timeline -->
		<div id="timeline" class="step" <?php $pos->reset_angle(); $pos->shiftprint([2600, 1300, 100], ["phi" => 10]); ?> data-scale="3">
		        <img src="img/timeline-1.png" alt="Timeline" width="1032" height="780" />
		</div>
		<div class="step" <?php $pos->shiftprint([3100, 548]); ?> data-scale="3">
		        <img src="img/timeline-2.png" alt="Timeline" width="1100" height="780" />
		</div>
		<!-- - -->

		<div class="step anim" <?php $pos->set_angle([0, 30, 0]); $pos->shiftprint([2000, 700]); ?> data-scale="2">
      <p><strong>El sistema aqu&iacute; reportado es tal cual fue usado en las elecciones de este a&ntilde;o</strong> en la CABA</p>
		</div>
		<!-- -->

		<!-- macro description of the system -->
		<!-- -machine -->
    <div id="macro" class="step" <?php $pos->reset_angle(); $pos->shiftprint([4000, 200]); ?> data-scale="1">
      <h2>Visi&oacute;n general de Vot.Ar</h2>
      <div class="overlay-img-txt">
	      <img src="img/overview.png" alt="overview" width="600" height="600" />
        <span class="txt-tiny pale-yellow">Unidad portable, algo m&aacute;s grande que un malet&iacute;n</span>
			</div>
		</div>

		<div class="step anim" <?php $pos->shiftprint(-700, ["phi" => -10]); ?> data-scale="1">
      <p>Tiene a la izquierda:</p>
      <ul>
   	   <li>Pantalla t&aacute;ctil para operar<br />(elegir candidatos y dem&aacute;s)</li>
      </ul>
		</div>

		<div class="step anim" <?php $pos->shiftprint(1350, ["phi" => 20]); ?> data-scale="1">
      <p>Tiene a la derecha:</p>
      <ul>
        <li>Slot de boleta: un lector/escritor RFID + impresora t&eacute;rmica</li>
      </ul>
		</div>

		<div class="step" <?php $pos->shiftprint([-850, -600], [30, 0, -10]); ?> data-scale="1">
      <p>Tiene arriba:</p>
      <ul>
        <li>
        DVD R/W, LEDs de estado y puertos:
        <table>
          <tr>
            <td>
              <ul>
                <li><em>USB *</em></li>
                <li>SVGA</li>
              </ul>
            </td>
            <td>
              <ul>
                <li>Ethernet</li>
                <li>Speaker</li>
              </ul>
            </td>
          </tr>
        </table>
        accesible por todos, bajo una peque&ntilde;a tapa
        </li>
      </ul>
      <p class="footnote">* BadUSB?...</p>
		</div>

		<div class="step" <?php $pos->shiftprint([100, 1200], -60); ?> data-scale="1">
      <p>Tiene por debajo:</p>
      <ul>
        <li>una fuente de alimentaci&oacute;n + 2 packs de bater&iacute;as</li>
        <li>y a veces, &iexcl;un cable JTAG!</li>
      </ul>
		</div>
		<!-- - -->

    <div class="step" <?php $pos->reset_angle(); $pos->shiftprint(["y" => 400]); ?> data-scale="1">
      <p>Luego est&aacute; la boleta, que tiene un chip RFID + papel t&eacute;rmico al dorso.</p>
      <p>Tambi&eacute;n cuenta con un troquel en una esquina, para verificar que la boleta no haya sido intercambiada.</p>
      <p class="footnote">Enseguida los detalles...</p>
		</div>

    <div class="step" <?php $pos->shiftprint(["y" => 350]); ?> data-scale="1">
      <p>Pero la propaganda dec&iacute;a:</p>
      <q>&iexcl;Es una impresora, no una computadora!</q>
      <p><small>&iexcl;y todos lo creyeron!</small></p>
		</div>
    <div class="step" <?php $pos->shiftprint(["y" => 360]); ?> data-scale="1">
      <video width="864" height="480" controls>
        <source src="vid/es_una_impresora.webm" type="video/webm">
        Montenegro y Angelini: Es una impresora.
      </video>
		</div>

    <div class="step" <?php $pos->shiftprint(["y" => 960], 10); ?> data-scale="2">
      <div class="overlay-img-txt centered">
        <img src="img/tweeting-machine.png" alt="Tweeting from a Vot.Ar machine" width="1219" height="652" />
        <span class="bottom flag-blue txt-reduced">As&iacute; que ac&aacute; tuiteabamos, desde una "impresora"...</span>
      </div>
		</div>
		<!-- -->

		<!-- electoral process -->
		<!-- -opening station -->
    <div class="step" <?php $pos->reset_angle(); $pos->shiftprint(["y" => 1000]); ?> data-scale="1">
    	<h2 class="centered">Vistazo r&aacute;pido: Abriendo la mesa</h2>
      <ul>
        <li>La empresa provee de m&aacute;quinas, boletas y de un grupo de t&eacute;cnicos por escuela.</li>
        <li>Los t&eacute;cnicos poseen credencial con chip RFID.</li>
			</ul>
    </div>
	  <div class="step" <?php $pos->shiftprint(["y" => 550], ["theta" => 10]); ?> data-scale="1">
	  	<ul>
				<li class="txt-reduced"><img class="align-left" src="img/dvd-recording.jpg" alt="DVDs recording" width="515" height="399" />El software se graba durante un evento llamado "de grabaci&oacute;n de DVD", donde representantes de la empresa junto a representantes de la Autoridad Electoral, fiscales y veedores, <em>mientras reeven m&aacute;gicamente el c&oacute;digo fuente en una pantalla</em> lo graban y entregan a la Autoridad Electoral (TSJ).</li>
    	</ul>
  	</div>
    <div class="step" <?php $pos->shiftprint(["y" => 550], ["theta" => 10]); ?> data-scale="1">
    	<ul>
        <li><img class="align-right" src="img/dvd.jpg" alt="DVDs and President Id card" width="500" height="281" />La Autoridad Electoral provee el DVD en sobre lacrado junto a la credencial de Presidente de Mesa (c/ chip RFID) y datos de Log-in.</li>
      </ul>
		</div>
    <div class="step" <?php $pos->shiftprint(["y" => 650], ["theta" => -30]); ?> data-scale="1">
      <ol>
        <li>Encender la m&aacute;quina e insertar el DVD.</li>
        <li><img class="align-right" src="img/screen-calib.jpg" alt="Screen calibration" width="360" height="345" />Seguir las instrucciones para calibrar la pantalla t&aacute;ctil.</li>
			</ol>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 400], ["theta" => -10]); ?> data-scale="1">
    	<ol start="3">
        <li><img src="img/president-id.jpg" alt="President ID" width="327" height="353" /><br />
Usar credencial de Presidente para abrir pantalla de inicio, ingresar n&uacute;mero de mesa y PIN.</li>
      </ol>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 650], ["theta" => -10]); ?> data-scale="1">
      <ol start="4">
        <li><img class="align-left" src="img/loggedin-screen.jpg" alt="Logged-in Screen" width="622" height="350" />Seleccionar la opci&oacute;n de Apertura de Mesa, ingresar la informaci&oacute;n solicitada.</li>
        <li>Insertar boleta especial que se imprimir&aacute; con los nombres del Presidente y Fiscales, la hora de apertura y un c&oacute;digo QR conteniendo esa misma info, que tambi&eacute;n se grabar&aacute; en el chip.</li>
      </ol>
		</div>
		<!-- -->
    <!-- -voting -->
    <div class="step" <?php $pos->shiftprint(1700, 15); ?> data-scale="1">
		  <h2 class="centered">Vistazo r&aacute;pido: Votando</h2>
		  <table>
				<tr>
					<td>
				    <ol>
           	 <li>Presentarse en la mesa, entregar DNI y obtener la boleta:<br />El Presidente de Mesa rentendr&aacute; una parte del troquel.</li>
				    </ol>
					</td>
					<td>
					  <div class="overlay-img-txt centered">
				      <img src="img/ballot-front.jpg" alt="Ballot" width="320" height="120" />
				      <span class="soft-green">1</span>
					  </div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
				    <ol start="2">
				      <li>Boleta en mano, dirigirse a la m&aacute;quina.</li>
				    </ol>
					</td>
				</tr>
				<tr>
					<td>
				    <ol start="3">
	            <li>Insertar la boleta en el slot:</li>
				    </ol>
					</td>
					<td>
					  <div class="overlay-img-txt centered">
		          <img src="img/inserting-ballot.jpg" alt="Inserting ballot" width="180" height="320" />
		          <span class="soft-green">3</span>
					  </div>
					</td>
				</tr>
		  </table>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 1250]); ?> data-scale="1">
		  <table>
				<tr>
					<td>
			      <ol start="4">
              <li>Elegir candidato o lista en la pantalla:</li>
			      </ol>
					</td>
					<td>
			      <div class="overlay-img-txt centered">
              <img src="img/picking-candidate.jpg" alt="Picking candidate" width="180" height="250" />
              <span class="soft-green">4</span>
			      </div>
					</td>
				</tr>
				<tr>
					<td>
			      <ol start="5">
		          <li>Al terminar, seleccionar la opci&oacute;n de votar (imprime la boleta y graba el chip). Retirar la boleta del slot.</li>
			      </ol>
					</td>
					<td>
				    <div class="overlay-img-txt centered">
		          <img src="img/ballot-back.jpg" alt="Ballot printed" width="320" height="131" />
		          <span class="soft-green">5</span>
				    </div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
			      <ol start="6">
              <li>Acercar la boleta al lector (o insertarla nuevamente) para verificar el voto, doblarla y volver a la mesa.</li>
              <li>El Presidente verificar&aacute; y remover&aacute; la otra parte del troquel.  Luego, depositar la boleta en la urna y recuperar el DNI.</li>
			      </ol>
					</td>
				</tr>
		  </table>
    </div>
    <!-- - -->
    <!-- -closing -->
    <div class="step" <?php $pos->shiftprint(1800, -15); ?> data-scale="1">
		  <h2 class="centered">Vistazo r&aacute;pido: Cerrando la mesa</h2>
		  <p>Al t&eacute;rmino de la votaci&oacute;n (18hs):</p>
		  <ol>
        <li>Iniciar sesi&oacute;n como Presidente.</li>
        <li>Insertar la Boleta de Apertura de Mesa.</li>
        <li>Seleccionar la opci&oacute;n de Cierre de Mesa, ingresar la hora actual.</li>
        <li>Insertar boleta especial de Cierre que tendr&aacute; informaci&oacute;n similar a la de Apertura.</li>
		  </ol>
    </div>
    <!-- - -->
    <!-- -scrutiny -->
    <div class="step" <?php $pos->shiftprint(1500, -15); ?> data-scale="1">
		  <h2 class="centered">Vistazo r&aacute;pido: Escrutinio</h2>
		  <ol>
        <li>Inmediatamente luego de cerrar la mesa, se activa el modo escrutinio.</li>
        <li>Elegir una boleta de la urna, verificar impresi&oacute;n y que no tenga marcas extra&ntilde;as.</li>
        <li>Acercarla a la m&aacute;quina para contabilizarla.</li>
        <li>Repetir para toda la urna.</li>
        <li>Al terminar, insertar boleta especial que ser&aacute; impresa con el resultado del escrutinio.  Se pueden imprimir tantas como se necesiten.</li>
        <li>Ahora debe insertarse una Boleta de Transimis&oacute;n de Escrutinio para continuar.</li>
		  </ol>
    </div>
    <!-- - -->
    <!-- -transmission -->
    <div class="step" <?php $pos->shiftprint(1600, -15); ?> data-scale="1">
      <h2 class="centered">Vistazo r&aacute;pido: Transmisi&oacute;n del escrutinio</h2>
      <ol>
        <li>Conectar la m&aacute;quina a la LAN.</li>
        <li>Insertar boleta especial.</li>
        <li>&iquest;&iquest;&iquest;???</li>
      </ol>
      <p>No hemos podido obtener informaci&oacute;n respecto de este punto.</p>
      <p>Durante nuestras pruebas, no logramos crear una boleta especial de transmisi&oacute;n, por lo que nunca pudimos completar este procedimiento.</p>
    </div>
    <!-- - -->
    <!-- -->

    <!-- HW deep -->
    <!-- -inside, all -->
    <div id="hwdeep" class="step" <?php $pos->reset_angle(); $pos->shiftprint(["y" => 1000]); ?> data-scale="1">
      <h2>Ahora veamos el HW en profundidad</h2>
      <div class="overlay-img-txt">
        <span class="pale-yellow">&iquest;Qu&eacute; hay dentro de la m&aacute;quina?</span>
        <img src="img/inside.jpg" alt="Inside the machine" width="1000" height="645" />
      </div>
    </div>

    <div class="step" <?php $pos->shiftprint([1200, 300], ["phi" => 25]); ?> data-scale="1">
		  <div class="overlay-img-txt">
		    <span class="pale-yellow" style="top: 130px;">M&aacute;s adentro (detr&aacute;s de la pantalla)</span>
		    <img src="img/inside-behind.jpg" alt="Behind the inside of the machine" width="1000" height="735" />
		  </div>
    </div>

    <div class="step" <?php $pos->shiftprint([800, 750], ["phi" => 25]); ?> data-scale="1">
		  <ul>
        <li>Puerto JTAG: se usa para programar/debuggear el uC.
	Acceso externo a trav&eacute;s de un cable cerca de las bater&iacute;as.</li>
		  </ul>
		  <div class="overlay-img-txt centered">
        <img src="img/jtag-elections.jpg" alt="JTAG exposed during elections" width="580" height="435" />
        <span class="soft-green txt-tiny">&iexcl;Algunas lo ten&iacute;an durante las elecciones!</span>
        <span class="bottom threat">Threat level: <i class="pastel-red">high</i></span><!-- DREAD 9 2 2 1 10 -->
		  </div>
		  <p class="txt-tiny centered pastel-red">&iexcl;Puede usarse para reprogramar el uC!</p>
		  <p class="footnote">M&aacute;s sobre esto en el <a class="link" target="_blank" href="https://blog.smaldone.com.ar/2015/07/15/el-sistema-oculto-en-las-maquinas-de-vot-ar">blog de Javier</a></p>
    </div>

    <div class="step anim" <?php $pos->shiftprint([-1200, -100], [25, 0, -25]); ?> data-scale="1">
      <ul>
        <li>Microprocessor (uP): Intel(R) Celeron(R) CPU N2930 @ 1.83GHz</li>
        <li>RAM memory: 2GB DDR3 1600</li>
        <li>Microcontroller (uC): Atmel AT91SAM7X256
				  <ul>
	          <li>Internal E2PROM memory: 256KB <b class="positioning">(!)</b></li>
				  </ul>
        </li>
      </ul>
    </div>
    <!-- - -->

    <!-- -uC -->
    <div class="step" <?php $pos->reset_angle(); $pos->shiftprint(["y" => 800]); ?> data-scale="1">
      <p>As&iacute; que, encontramos un subsistema desconocido:</p>
      <img src="img/secret-uc.png" alt="Secret microcontroller" width="568" height="582" />
    </div>
		<div class="step anim" <?php $pos->set_angle([0, 0, 10]); $pos->shiftprint([-1000, 400]); ?> data-scale="1">
	  	<img src="img/atmel-datasheet.jpg" alt="ATMEL datasheet" width="942" height="700" />
	  </div>
    <div class="step anim" <?php $pos->shiftprint([1600, -400, 0], ["phi" => -10]); ?> data-scale="1">
      <p>El uC ARM controla la impresora t&eacute;rmica y el lector/escritor RFID.</p>
      <p>Su memoria E2PROM interna es <b class="scaling-right">suficiente para almacenar</b><br />todos los votos emitidos y m&aacute;s.</p>
      <p>No sabemos <em>nada</em>, Jon Snow!</p>
    </div>
    <!-- - -->

    <!-- -ballots -->
    <div class="step" <?php $pos->shiftprint([1300, 400, -150], ["theta" => 10]); ?> data-scale="1">
      <h3>Sobre las boletas (BUE)</h3>
      <img src="img/ballot.jpg" alt="Ballot" width="1000" height="732" />
    </div>

    <div class="step" <?php $pos->shiftprint([1300, 100, -450], ["theta" => 10]); ?> data-scale="2">
    	<ul>
		    <li>Papel grueso impreso en el frente y papel t&eacute;rmico + chip RFID en el dorso.</li>
		    <li>Una delgada l&aacute;mina met&aacute;lica protege al chip de ser le&iacute;do cuando la boleta se encuentra <em>perfectamente</em> doblada sobre s&iacute; misma.</li>
      </ul>
    </div>

    <div class="step" <?php $pos->shiftprint([3000, 1000, 0], ["theta" => 10]); ?> data-scale="2">
    <img src="img/patente.jpg" alt="Patente voto electronico" width="1000" height="794" />
    </div>

    <div class="step" <?php $pos->shiftprint([-1900, 1000], [-10, -30]); ?> data-scale="1">
		  <h3>El chip RFID</h3>
		  <table class="white-row">
		    <tr>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Memoria (Bytes)</th>
          <th>Nota</th>
		    </tr>
		    <tr>
          <td>NXP</td>
          <td>ICODE SLI SL2ICS20 o SLIX SL2S2002 (ISO 15693)</td>
          <td>112</td>
          <td>c&oacute;digo ID &uacute;nico</td>
		    </tr>
		  </table>
		  <table class="white-row">
        <tr>
          <th colspan="3">Categor&iacute;as de Tag</th>
        </tr>
        <tr>
          <td>Tag Vac&iacute;o 0x0000</td>
          <td>Voto 0x0001</td>
          <td>T&eacute;cnico MSA 0x0002</td>
        </tr>
        <tr>
          <td>Presidente de Mesa 0x0003</td>
          <td>Escrutinio Finalizado 0x0004</td>
          <td>Apertura de Mesa 0x0005</td>
        </tr>
        <tr>
          <td>Demostraci&oacute;n 0x0006</td>
          <td>Transmisi&oacute;n de Escrutinio 0x007F</td>
          <td></td>
        </tr>
        <tr>
          <td>Tag Virgen 0x0007 (?)</td>
          <td>Addendum 0x007F (?)</td>
          <td>Tag desconocido 0xFFFF (?)</td>
        </tr>
		  </table>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 1000], 10); ?> data-scale="1">
		  <h4>Estructura de datos dentro del Tag</h4>
		  <code>K1 T2 T1 L1 C4 C3 C2 C1 D1...Dn W1 W2 W3 W4</code>
		  <table class="white-row">
		  <thead>
        <tr>
          <th>Tipo</th>
          <th>Desc</th>
          <th>Tama&ntilde;o (bytes)</th>
          <th>Endianness</th>
          <th>Guardado como</th>
          <th>Valor fijo</th>
        </tr>
		  </thead>
		  <tbody>
        <tr>
          <td>K</td>
          <td>Token</td>
          <td>1</td>
          <td>-</td>
          <td>HEX</td>
          <td>0x1C</td>
        </tr>
        <tr>
          <td>T</td>
          <td>Categor&iacute;a Tag</td>
          <td>2</td>
          <td>little-endian</td>
          <td>HEX</td>
          <td>-</td>
        </tr>
        <tr>
          <td>L</td>
          <td>Longitud de Datos</td>
          <td>1</td>
          <td>-</td>
          <td>HEX</td>
          <td>-</td>
        </tr>
        <tr>
          <td>C</td>
          <td>CRC32(Datos)</td>
          <td>4</td>
          <td>little-endian</td>
          <td>HEX</td>
          <td>-</td>
        </tr>
        <tr>
          <td>D</td>
          <td>Datos</td>
          <td>n</td>
          <td>-</td>
          <td>ASCII</td>
          <td>-</td>
        </tr>
        <tr>
          <td>W</td>
          <td>Write test?</td>
          <td>4</td>
          <td>-</td>
          <td>ASCII</td>
          <td>W_OK</td>
        </tr>
		  </tbody>
		  </table>
		  <p class="footnote">M&aacute;s info sobre &eacute;sto: ver punto IV. B del informe</p>
    </div>
    <!-- - -->
    <!-- -->

    <!-- SW deep-->
    <div id="swdeep" class="step" <?php $pos->reset_angle(); $pos->shiftprint([-1500, 800]); ?> data-scale="1">
      <h2>Momento de analizar el SW</h2>
      <p>Pudimos hacerlo gracias a alguien llamado <a class="link" target="_blank" href="https://twitter.com/prometheus_ar">Prometheus</a>, que <a class="link-shadow" target="_blank" href="https://github.com/prometheus-ar/vot.ar/">public&oacute; el c&oacute;digo fuente</a>.<p>
      <ul>
        <li>Escrito en Python.</li>
        <li>Se emplea un <i>live-dvd</i>:
		      <ul>
		        <li>Linux Ubuntu-based (un poco recortado).</li>
		        <li>El contenido/archivo de hashes <em>no est&aacute; firmado criptogr&aacute;ficamente</em> (el DVD puede ser reemplazado sin m&aacute;s).</li>
		        <li>No se implementa UEFI/SecureBoot.</li>
		      </ul></li>
      </ul>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 710]); ?> data-scale="1">
      <video width="864" height="480" controls>
        <source src="vid/angelini.webm" type="video/webm">
        Angelini sobre la maquina.
      </video>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 620]); ?> data-scale="1">
      <ul>
        <li>El programa se ejecuta como <em>root</em>.</li>
        <li>Credenciales de Log-in se hardcodean en archivo .json.</li>
        <li>Carece completamente de documentaci&oacute;n (p&uacute;blica) y de documentaci&oacute;n en el c&oacute;digo.</li>
        <li>Muy pocos comentarios, incluso desacertados.</li>
        <li>C&oacute;digo desprolijo.</li>
        <li>Sin pruebas unitarias.</li>
      </ul>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 360]); ?> data-scale="1">
      <p>Esto hace que el c&oacute;digo sea dif&iacute;cil de leer, auditar, mantener, mejorar...</p>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 150], 180); ?> data-scale="1">
      <p>...pero es ideal para gestar bugs desagradables...</p>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 150], -180); ?> data-scale="1">
      <p>...tales como <b class="scaling">#multivoto</b> y otros...</p>
    </div>

    <!-- -command injection -->
    <div id="commi" class="step" <?php $pos->shiftprint([1200, -100, 1500], ["theta" => 90]); ?> data-scale="1">
      <h2>Inyecci&oacute;n de Comandos</h2>
      <p>Alfredo Ortega encontr&oacute; una vulnerabilidad de inyecci&oacute;n de comandos en la rutina de generador de c&oacute;digos QR.</p>
      <ol>
        <li>msa/core/clases.py, l&iacute;nea 190: <code>a_qr_str()</code> devuelve una lista de valores separados por comas.</li>
        <li>msa/core/clases.py, l&iacute;nea 206: <code>a_qr()</code> env&iacute;a esos valores a la funci&oacute;n vulnerable.</li>
        <li>msa/core/qr.py, l&iacute;nea 13: <code>crear_qr()</code> <strong>funci&oacute;n vulnerable</strong>, ejecuta el comando sin sanitizar.</li>
      </ol>
    </div>

	  <div class="step" <?php $pos->shiftprint([200, 800], -25); ?> data-scale="1">
			<img src="img/ci-code.jpg" alt="Command Injection Code" width="623" height="600" />
    </div>

    <div class="step" <?php $pos->shiftprint(["y" => 900], 25); ?> data-scale="1">
      <p>Esta rutina se ejecuta para imprimir el QR de los nombres del Presidente de Mesa y Fiscales.</p>
      <ul>
		    <li>Nombre: <pre>Juan</pre></li>
		    <li>Apellido: <pre>Perez;echo 'this is bad!'</pre></li>
      </ul>
      <p class="txt-reduced">La pantalla de ingreso de nombres s&iacute; sanitiza y tiene un l&iacute;mite de longitud, por lo que explotar esta vulnerabilidad es complicado.</p>
      <p class="centered threat">Threat level: <i class="medium-orange">medium</i></p>
    </div><!-- DREAD 3 1 8 1 10 -->
    <!-- - -->

    <!-- -multivote -->
    <div id="multivote" class="step" <?php $pos->shiftprint([400, 1200, 800], ["theta" => -180]); ?> data-scale="2">
      <h2>Multivoto</h2>
      <p>Esta vulnerabilidad permite a un atacante <strong class="pastel-red">a&ntilde;adir varios votos</strong> al chip RFID, tantos como soporte la memoria del chip (cerca de <strong>10~12 votos</strong>).</p>
      <p><em>No es obligatorio distribuir los votos de forma especial</em>: pueden ser para un &uacute;nico candidato, o divirse entre varios candidatos, en la misma categor&iacute;a u otra.</p>
      <p class="centered threat">Threat level: <i class="critical-purple">critical</i> (CVE-2015-6839)</p><!-- DREAD 9 8 3 10 10 -->
    </div>
    <div class="step" <?php $pos->shiftprint([400, 1200, 0]); ?> data-scale="1">
    	<img src="img/multivote.jpg" alt="Multivote" width="620" height="700" />
    </div>
    <div class="step" <?php $pos->shiftprint([-400, -1500, -1500],["theta" => 10]); ?> data-scale="1">
	    <p><em>No es posible diferenciar</em> entre una <em>boleta multivoto</em> y una <em>normal</em> a simple vista.</p>
	    <p>As&iacute; que, un atacante con acceso a una impresora t&eacute;rmica y boletas (no es muy dif&iacute;cil de conseguir) <em>podr&iacute;a emitir votos de antemano</em> que son muy dif&iacute;ciles de detectar.</p>
	    <p>Fue reconocido por la auditor&iacute;a del Prof. Righetti en su &uacute;ltima publicaci&oacute;n (pero disminuido de importancia).</p>
    </div>
    <div class="step" <?php $pos->shiftprint([-800, 0, -1200]); ?> data-scale="1">
    	<p>El m&eacute;todo vulnerable es <code>desde_string</code> de la clase <code>Seleccion</code> en <i>msa/core/clases.py</i></p>
    	<h3>Pseudoc&oacute;digo</h3>
    	<img src="img/multivote-pseudo.jpg" alt="Multivote pseudocode" width="450" height="327" />
    </div>
    <div class="step" <?php $pos->shiftprint([-800, 0, -1200], ["theta" => 10]); ?> data-scale="1">
      <h4>Multivotar es f&aacute;cil, solo hay que construir el string de voto</h4>
      <p>Este ser&iacute;a un voto normal para “Diputado” (DIP), “Jefe de Gobierno” (JEF) y “Jefe Comunal” (COM) para la CABA: <code>06CABA.1COM567DIP432JEF123</code>.</p>
      <p>Y este ser&iacute;a el string de <i>multivoto</i>: <code>06CABA.1JEF123JEF123JEF123COM567DIP432</code> donde el Jefe de Gobierno obtuvo <em>tres votos</em> y el resto de las categor&iacute;as, uno.</p>
      <p class="footnote">Ver punto IV. B. 1 y Ap&eacute;ndice B. C del informe</p>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 810]); ?> data-scale="1">
      <p>Por ejemplo, es factible conseguir algo de info online, en la p&aacute;gina de la autoridad electoral:</p>
      <div class="centered">
        <img src="img/login-json-online.jpg" alt="https://www.eleccionesciudad.gob.ar/simulador/datos/" width="511" height="300" />
        <img src="img/candidatos-json-online.jpg" alt="https://www.eleccionesciudad.gob.ar/simulador/datos/CABA/Candidatos.json" width="360" height="600" class="right" />
      </div>
    </div>
    <!-- - -->

    <!-- -bypassing log-in -->
    <div id="bypass" class="step" <?php $pos->reset_angle(); $pos->shiftprint([-1200, 800]); ?> data-scale="1">
		  <h2>Salteando pantalla de inicio de sesi&oacute;n</h2>
		  <h3>Suplantar al T&eacute;cnico o Presidente de Mesa</h3>
		  <p class="right">Esto es trivial dado que <em>ninguna autenticaci&oacute;n</em> es usada para con los datos del chip.</p>
		  <p>Obtener algunos chips RFID y:</p>
		  <ol>
        <li>Crear una boleta falsa de <i>Apertura de Mesa.</i></li>
        <li>Crear una boleta de <i>Presidente de Mesa.</i></li>
        <li>Crear una boleta de <i>T&eacute;cnico.</i></li>
		  </ol>
    </div>
    <div class="step" <?php $pos->shiftprint([-200, 1100, 50]); ?> data-scale="2">
      <div class="overlay-img-txt txt-reduced pale-yellow">
        <img src="img/start-screen.jpg" alt="Home Screen" width="711" height="400" />
        <span>Usar la boleta de Presidente para<br />abrir la pantalla de inicio de sesi&oacute;n</span>
      </div>
    </div>
    <div class="step" <?php $pos->shiftprint([1800, 250], ["theta" => -25]); ?> data-scale="2">
      <div class="overlay-img-txt txt-reduced pale-yellow">
        <img src="img/login-screen.jpg" alt="Log-in Screen" width="711" height="400" />
        <span>Usar la boleta de Apertura de Mesa<br />para saltear el ingreso de PIN</span>
      </div>
    </div>
    <div class="step" <?php $pos->shiftprint([1400, 450, 150], ["theta" => -25]); ?> data-scale="2">
      <div class="overlay-img-txt txt-reduced centered flag-blue">
        <img src="img/loggedin-screen.jpg" alt="Logged-in Screen" width="711" height="400" />
        <span>¡Listo!</span>
      </div>
    </div>
    <div class="step" <?php $pos->shiftprint([700, 100, 1300], ["theta" => -25]); ?> data-scale="1">
			<div class="overlay-img-txt txt-reduced pale-yellow">
        <img src="img/maintenance-screen.jpg" alt="Maintenance screen" width="900" height="566" />
        <span>Ahora con la boleta de T&eacute;cnico...<br/>
        ...ingresar al modo mantenimiento</span>
      </div>
      <p class="centered threat">Threat level: <i class="pastel-red">high</i></p><!-- DREAD 5 10 8 1 10 -->
      <p class="txt-reduced">Permite eyectar el DVD y algunos DoS.  Otra evidencia de un mal dise&ntilde;o...</p>
    </div>
    <!-- - -->
    <!-- -->

		<!-- homebanking -->
    <div id="homebanking" class="step" <?php $pos->reset_angle(); $pos->set_coord(["z" => 0]); $pos->shiftprint(["y" => 1800]); ?> data-scale="1">
			<h1>&iquest;Por qu&eacute; s&iacute; <em>homebanking</em> y no voto electr&oacute;nico?</h1>
			<blockquote>Pero, ¿no confiamos nuestro dinero y hasta nuestras vidas en sistemas inform&aacute;ticos? No, no lo hacemos. Usamos cajeros y homebanking para mover nuestro dinero, pero al hacer un movimiento importante seguramente conservaremos el n&uacute;mero de comprobante hasta asegurarnos de que todo ha ido bien.</blockquote>
		</div>
    <div class="step" <?php $pos->shiftprint(["y" => 900]); ?> data-scale="1">
			<blockquote>Usamos sistemas inform&aacute;ticos en nuestros autom&oacute;viles, pero lejos estamos de dejarlos conducir despreocupadamente.  Y todo esto, a&uacute;n cuando podemos suponer que tanto los fabricantes de cajeros como los de autom&oacute;viles no har&aacute;n ninguna manipulaci&oacute;n para que sus productos se comporten de forma indeseada. ¿Podemos asegurar esto cuando hablamos de un sistema electoral? Claramente, no.</blockquote>
			<p class="footnote">J. Smaldone, <a class="link" href="http://www.perfil.com/politica/Por-que-es-peligroso-cualquier-sistema-de-voto-electronico-20150428-0050.html">Por qu&eacute; es peligroso cualquier sistema de voto electr&oacute;nico</a></p>
		</div>
    <div class="step anim" <?php $pos->shiftprint(1000); ?> data-scale="1">
			<h3>Voto Electr&oacute;nico</h3>
			<ul>
				<li>totalmente an&oacute;nimo, secreto</li>
			</ul>
			<h3>Homebanking</h3>
			<ul>
				<li>se debe conocer y registrar los parametros de una transacci&oacute;n</li>
				<li>m&uacute;ltiples registros: banco emisor, banco receptor, dispositivo  – cajero, posnet, etc. -, entidad financiera, cliente/usuario, etc.</li>
			</ul>
			<p class="centered">No solo no son semejantes, <b class="scaling">sino que son opuestos</b></p>
		</div>
    <div class="step" <?php $pos->shiftprint(["y" => 900]); ?> data-scale="1">
			<blockquote>Todas las partes involucradas en el Homebanking se ven beneficiadas por un sistema seguro y confiable, pero eso todas ellas trabajan en conjunto para velar por su credibilidad. Aquellos que est&aacute;n interesados en vulnerar el sistema inform&aacute;tico bancario son externos al sistema en s&iacute; mismo buscando alg&uacute;n r&eacute;dito personal.<br />
Con un sistema de votaci&oacute;n es exactamente al rev&eacute;s: muchas de sus partes involucradas se ven beneficiadas al vulnerar el sistema y sacar una tajada m&aacute;s de votos.</blockquote>
		</div>
    <!-- -->

    <!-- bue vs bup -->
    <div id="buebup" class="step" <?php $pos->reset_angle(); $pos->set_coord(["z" => 0]); $pos->shiftprint(["y" => 1800]); ?> data-scale="1">
      <h2 class="centered">Algunas palabras sobre la BUP</h2>
		</div>
    <div class="step" <?php $pos->shiftprint(["y" => 500]); ?> data-scale="1">
      <img src="img/bue-voto-economia.jpg" alt="voto economia" width="433" height="600" />
      <p class="footnote">Infograf&iacute;as por <a class="link" href="https://twitter.com/rusosnith">Andres Snitcofsky</a>.</p>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => -46], ["theta" => 90]); ?> data-scale="1">
      <img src="img/bue-bateria.jpg" alt="bateria" width="433" height="600" />
    </div>
    <div class="step" <?php $pos->shiftprint(["z" => -600]); ?> data-scale="1">
      <img src="img/bue-dvds.jpg" alt="dvds" width="433" height="600" />
    </div>
    <div class="step" <?php $pos->shiftprint([600, 0, 600], ["theta" => -90]); ?> data-scale="1">
      <img src="img/bue-boleta.jpg" alt="boleta" width="433" height="600" />
    </div>
    <!-- -->

    <!-- bying votes and stuff... -->
    <div class="step" <?php $pos->reset_angle(); $pos->set_coord(["z" => 0]); $pos->shiftprint(["y" => 1200]); ?> data-scale="1">
		  <h2>Viejas amenazas actualizadas</h2>
		  <h4>Algunos ataques comunes a los sistemas electorales</h4>
		  <ul>
		          <li>Urna embarazada</li>
		          <li>El presi-militante</li>
		          <li>Voto calesita (cadena)</li>
		          <li>Clientelismo</li>
		          <li>Robo de boletas</li>
		          <li>La tapadita</li>
		          <li>El factor cartero</li>
		  </ul>
		  <p class="footnote">Explicaci&oacute;n mucho m&aacute;s detallada <a class="link" target="_blank" href="https://blog.smaldone.com.ar/2015/09/04/boleta-unica-versus-boleta-unica-electronica/">por Javier</a></p>
    </div>
    <div class="step" <?php $pos->shiftprint([1300, 100], ["phi" => 10]); ?> data-scale="1">
      <p>No hay mayor ventaja de uno u otro sistema en ning&uacute;n punto.</p>
      <p class="txt-reduced">(entonces, &iquest;sin mejoras respecto de un simple papel?)</p>
      <br />
      <p>Y sin embargo, este sistema introduce una nueva forma de <i>comprar votos</i>, que puede ser explotada por <em>los punteros</em>.</p>
    </div>
    <div class="step" <?php $pos->shiftprint([1300, 200], ["phi" => 10]); ?> data-scale="1">
      <p>Es muy f&aacute;cil ocultar un tel&eacute;fono celular entre la ropa con una aplicaci&oacute;n para leer el contenido del chip:</p>
      <img src="img/point-men.jpg" alt="Buying votes" width="851" height="450" />
      <p class="footnote">Gracias a <a class="link" href="https://twitter.com/autopolitics" target="_blank">Trist&aacute;n Grimaux</a> por la app - <a class="link" href="https://github.com/tristangrimaux/CardReaderVotar" target="_blank">Get the code!</a></p>
    </div>
    <!-- -->

	  <!-- ethics -->
		<div id="ethics" class="step" <?php $pos->set_angle([-30, 0, 0]); $pos->set_coord(["z" => 0]); $pos->shiftprint(["y" => 1200]); ?> data-scale="1">
      <h1>&Eacute;tica y moral</h1>
			<blockquote>Technological  optimists  believe  that  technology makes  life  better.  According  to  this  view,  we  live  longer,  have  more  freedom, enjoy  more  leisure.  Technology  enriches  us  [and] has become this extraordinary tool for human development. At this point, it is central to mankind's mission.</blockquote>
			<p class="footnote">P. Rogaway, p. 9, "The Moral Character of Cryptographic Work", 2015</p>
		</div>
    <div class="step" <?php $pos->shiftprint([1000, 300], ["phi" => 20]); ?> data-scale="1">
			<h2>&iquest;Pero y qu&eacute; si las ciencias de la computaci&oacute;n no est&aacute;n beneficiandonos?</h2>
		</div>
    <div class="step" <?php $pos->shiftprint([700, 500], ["phi" => 20]); ?> data-scale="1">
			<blockquote>our moral duties extend beyond the imperative that you personally do no harm: you have to try to promote the social good, too. [...] your moral duties stem not just from your stature as a moral individual, but, also, from the professional communities to which you belong: cryptographer, computer scientist, scientist, technologist</blockquote>
			<p class="footnote">P. Rogaway, p. 10, "The Moral Character of Cryptographic Work", 2015</p>
		</div>
    <div class="step" <?php $pos->shiftprint([1000, 0], ["phi" => 20]); ?> data-scale="1">
			<p>As&iacute; me hace sentir este tema:</p>
			<blockquote>From my earliest days I had a passion for science. But science, the exercise of the supreme power of the human intellect, was always linked in my mind with benefit to people. I saw science as being in harmony with humanity. I did not imagine that the second half of my life would be spent on efforts to avert a mortal danger to humanity created by science.</blockquote>
			<p class="footnote">J. Rotblat, "Remember your humanity", 1995</p>
		</div>
    <!-- -->

    <!-- summary -->
		<div id="summary" class="step" <?php $pos->reset_angle(); $pos->set_coord(["z" => 0]); $pos->shiftprint(["y" => 1500]); ?> data-scale="2">
			<h1 style="text-align: center;">Resumiendo...</h1>
      <ul>
		    <li>Malas t&eacute;cnicas de programaci&oacute;n derivaron en <span class="pastel-red">vulnerabilidades</span>.</li>
		    <li>P&eacute;sima elecci&oacute;n del sistema de soporte/almacenamiento de votos.</li>
		    <li>No satisface los <a href="#req" class="link-shadow">requerimientos:</a>
		    <ul>
          <li><em>Viola</em> el secreto del voto.</li>
          <li><em>M&aacute;s de un</em> voto por elector.</li>
          <li>Es <em>oscuro</em> para el votante (y para todos).</li>
		    </ul>
		    </li>
		    <li>No se tienen ventajas significativas respecto del sistema de Boleta &Uacute;nica de Papel.</li>
      </ul>
		</div>
		<div class="step" <?php $pos->shiftprint(2500, 45); ?> data-scale="2">
		  <p>Como la Suprema Corte de Alemania dictamin&oacute;, de acuerdo a su Constituci&oacute;n:</p>
		  <blockquote>Cuando se utilizan m&aacute;quinas de voto electr&oacute;nico, <strong>debe ser posible para el ciudadano verificar los pasos escenciales del proceso electoral</strong> y verificar los resultados de forma fiable y <strong>sin ning&uacute;n conocimiento especial de experticia</strong>.</blockquote>
		  <!--<p class="footnote"><a class="link-shadow" target="_blank" href="http://www.bundesverfassungsgericht.de/SharedDocs/Entscheidungen/EN/2009/03/cs20090303_2bvc000307en.html">Reference</a></p>-->
		</div>
    <!-- -->

  	<!-- conclusions -->
    <div id="conclusions" class="step anim slide" <?php $pos->reset_angle(); $pos->shiftprint([3000, 50, 50]); ?> data-scale="3">
			<h1 style="text-align: center;">Conclusi&oacute;n</h1>
      <p>Despu&eacute;s de todo lo visto:</p>
      <ul>
        <li>&iquest;En verdad <em>creen</em> que es una <i>impresora</i>?</li>
        <li>Incertidumbre del resultado de la elecci&oacute;n sin escrutinio manual (&iquest;entonces para qu&eacute; necesitamos a este sistema?)</li>
        <li>Los riesgos introducidos por el voto electr&oacute;nico son mayores que sus beneficios</li>
        <li><strong>Ning&uacute;n avance t&eacute;cnico debe debilitar la democracia</strong></li>
      </ul>
      <p><b class="positioning">Concluimos que este sistema no cumple sus objetivos e introduce riesgos al proceso electoral</b></p>
		</div>
    <!-- -->

    <!-- questions -->
		<div class="step slide" <?php $pos->reset_angle(); $pos->set_coord(["z" => 0]); $pos->shiftprint(["y" => 2000]); ?> data-scale="2">
			<h1 style="text-align: center;">&iquest;Preguntas?</h1>
      <p>&iexcl;Espero que hayan disfrutado de esta presentaci&oacute;n!.  Pueden realizar cualquier pregunta, <em>sin restricciones</em>*.</p>
      <p>Les planteo algunas:</p>
      <ul>
				<li>&iquest;C&oacute;mo es que ninguna auditor&iacute;a encontr&oacute; estos problemas?</li>
        <li>&iquest;Resolvi&oacute; MSA estos problemas?</li>
        <li>&iquest;Ataques conocidos contra RFID?</li>
        <li>&iquest;Puede la urna ser le&iacute;da remotamente?</li>
        <li>Mencionaron BadUSB... &iquest;qu&eacute; hay con eso?</li>
        <li>&iquest;Qu&eacute; cambios propondr&iacute;an a este sistema Vot.Ar?</li>
      </ul>
			<p class="footnote">algunas restricciones pueden aplicar...</p>
		</div>
    <!-- -->

		<!-- goodbye -->
		<div class="step slide" <?php $pos->shiftprint(1600); ?> data-scale="1">
			<h1 style="text-align: center;">&iquest;M&aacute;s informaci&oacute;n?</h1>
			<br />
			<p>Pueden ver el informe, esta presentaci&oacute;n y m&aacute;s en el repo git:</p>
      <p class="right txt-verybig"><a class="link" target="_self" href="https://bit.ly/votar-report">bit.ly/votar-report</a></p>
      <br />
      <p>Divulgalo! (CC BY-SA v4.0).</p>
      <br /><br /><br />
			<p class="footnote">Powered by <a class="link-shadow" target="_blank" href="https://github.com/bartaz/impress.js">impress.js</a></p>
		</div>
    <!-- -->

    <!-- thanks -->
		<div id="last" class="step anim slide" <?php $pos->shiftprint(1100); ?> data-scale="1">
			<h1 style="text-align: center;">&iexcl;Gracias por escuchar!</h1>
			<p>Quiero tambi&eacute;n <b class="scaling">agradecer a todos</b> los que nos apoyaron:</p>
      <ul>
        <li><span class="soft-green">CaFeLUG</span> (Sergio Aranda Peralta, Ximena Garc&iacute;a, Lucas Lakousky, Juan Muguerza, Eugenia N&uacute;&ntilde;ez, Sergio Orbe, Andr&eacute;s Paul)</li>
        <li><span class="soft-green">Fundaci&oacute;n V&iacute;a Libre</span></li>
        <li><span class="soft-green">Julio L&oacute;pez</span> y <span class="soft-green">Trist&aacute;n Grimaux</span></li>
        <li>Nuestros <span class="soft-green">amigos</span> que siempre est&aacute;n...</li>
      </ul>
      <p>Y a los organizadores de este evento por darme un lugar para compartir, en especial a <span class="soft-green">Carlos Pantelides</span>.</p>
		</div>
    <!-- -->

    <!-- overview -->
    <?php
      if ($show_overview) {
        $pos->autoset_overview();
        $pos->print_overview();
      }
    ?>
    <!-- -->
	</div>

	<!-- impress code -->
	<!-- -hint -->
	<div class="hint">
                <p>Utiliza las flechas del teclado para avanzar/retroceder</p>
	</div>
	<script>
		if ("ontouchstart" in document.documentElement) {
		document.querySelector(".hint").innerHTML = "<p>Toca la parte derecha de la pantalla para avanzar</p>";
		}
	</script>
  <!-- - -->

	<script src="js/impress.js"></script>
	<script>impress().init();</script>
	<!-- -->
</body>
</html>
