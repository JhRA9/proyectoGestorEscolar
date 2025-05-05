from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import os

# Configuro el navegador para realizar las pruebas
driver = webdriver.Chrome()  # Asegúrate de tener el controlador de Chrome instalado
driver.get("http://localhost/proyectoEscuela/login/index.php")  # Accedo a la página de inicio de sesión

# Creo una carpeta para guardar las capturas de pantalla
if not os.path.exists("Capturas de pantalla"):
    os.makedirs("Capturas de pantalla")

# Función para tomar capturas de pantalla
def capturar_pantalla(nombre):
    driver.save_screenshot(f"Capturas de pantalla/{nombre}.png")

# Función para verificar si el usuario fue redirigido correctamente
def verificar_redireccion(url_esperada):
    return url_esperada in driver.current_url

# Flujo 1: Inicio de sesión exitoso con credenciales correctas
try:
    print("Probando inicio de sesión exitoso...")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("admin@admin.com")  # Uso un correo válido
    driver.find_element(By.NAME, "password").send_keys("123")  # Uso una contraseña válida
    capturar_pantalla("flujo1_ingresando_datos")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    capturar_pantalla("flujo1_login_exitoso")
    if verificar_redireccion("admin"):
        print("Flujo 1: Inicio de sesión exitoso - PASÓ")
    else:
        print("Flujo 1: Inicio de sesión exitoso - FALLÓ")
except Exception as e:
    print(f"Flujo 1: Inicio de sesión exitoso - FALLÓ: {e}")

# Flujo 2: Inicio de sesión fallido con campos vacíos
try:
    print("Probando inicio de sesión con campos vacíos...")
    driver.get("http://localhost/proyectoEscuela/login/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("")  # Dejo el campo vacío
    driver.find_element(By.NAME, "password").send_keys("")  # Dejo el campo vacío
    capturar_pantalla("flujo2_ingresando_datos_vacios")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    capturar_pantalla("flujo2_mensaje_error")
    alerta = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.CLASS_NAME, "swal2-title"))
    ).text
    if "Los datos son incorrectos" in alerta:
        print("Flujo 2: Inicio de sesión con campos vacíos - PASÓ")
    else:
        print("Flujo 2: Inicio de sesión con campos vacíos - FALLÓ")
except Exception as e:
    print(f"Flujo 2: Inicio de sesión con campos vacíos - FALLÓ: {e}")

# Flujo 3: Inicio de sesión fallido con credenciales incorrectas
try:
    print("Probando inicio de sesión con credenciales incorrectas...")
    driver.get("http://localhost/proyectoEscuela/login/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("usuario_invalido@gmail.com")  # Uso un correo inválido
    driver.find_element(By.NAME, "password").send_keys("contraseña_invalida")  # Uso una contraseña inválida
    capturar_pantalla("flujo3_ingresando_datos_invalidos")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    capturar_pantalla("flujo3_mensaje_error")
    alerta = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.CLASS_NAME, "swal2-title"))
    ).text
    if "Los datos son incorrectos" in alerta:
        print("Flujo 3: Inicio de sesión con credenciales incorrectas - PASÓ")
    else:
        print("Flujo 3: Inicio de sesión con credenciales incorrectas - FALLÓ")
except Exception as e:
    print(f"Flujo 3: Inicio de sesión con credenciales incorrectas - FALLÓ: {e}")

# Flujo 4: Verifico que la contraseña no se muestre en texto plano
try:
    print("Verificando que la contraseña no se muestre en texto plano...")
    driver.get("http://localhost/proyectoEscuela/login/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "password")))
    password_field = driver.find_element(By.NAME, "password")
    capturar_pantalla("flujo4_password_oculta")
    if password_field.get_attribute("type") == "password":
        print("Flujo 4: Contraseña no visible en texto plano - PASÓ")
    else:
        print("Flujo 4: Contraseña no visible en texto plano - FALLÓ")
except Exception as e:
    print(f"Flujo 4: Contraseña no visible en texto plano - FALLÓ: {e}")

# Flujo 5: Verifico que no se pueda acceder al módulo de administración sin iniciar sesión
try:
    print("Probando acceso sin iniciar sesión...")
    driver.get("http://localhost/proyectoEscuela/admin/index.php")
    capturar_pantalla("flujo5_acceso_sin_sesion")
    if "login" in driver.current_url:
        print("Flujo 5: Acceso sin iniciar sesión - PASÓ")
    else:
        print("Flujo 5: Acceso sin iniciar sesión - FALLÓ")
except Exception as e:
    print(f"Flujo 5: Acceso sin iniciar sesión - FALLÓ: {e}")

# Flujo 6: Verifico que un usuario sin permisos no pueda acceder al módulo de administración
try:
    print("Probando acceso con un usuario sin permisos de administrador...")
    driver.get("http://localhost/proyectoEscuela/login/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("usuario@usuario.com")  # Correo de un usuario sin permisos
    driver.find_element(By.NAME, "password").send_keys("123")  # Contraseña válida
    capturar_pantalla("flujo6_ingresando_datos_usuario")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    capturar_pantalla("flujo6_usuario_sin_permisos")

    # Intento acceder al módulo de administración
    driver.get("http://localhost/proyectoEscuela/admin/index.php")
    capturar_pantalla("flujo6_intento_acceso_admin")
    if "login" in driver.current_url or "error" in driver.page_source:
        print("Flujo 6: Acceso con usuario sin permisos - PASÓ")
    else:
        print("Flujo 6: Acceso con usuario sin permisos - FALLÓ")
except Exception as e:
    print(f"Flujo 6: Acceso con usuario sin permisos - FALLÓ: {e}")

# Flujo 7: Verifico que un administrador pueda acceder al módulo de administración
try:
    print("Probando acceso con un administrador...")
    driver.get("http://localhost/proyectoEscuela/login/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("admin@admin.com")  # Correo de un administrador
    driver.find_element(By.NAME, "password").send_keys("123")  # Contraseña válida
    capturar_pantalla("flujo7_ingresando_datos_admin")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    capturar_pantalla("flujo7_admin_acceso")

    # Intento acceder al módulo de administración
    driver.get("http://localhost/proyectoEscuela/admin/index.php")
    capturar_pantalla("flujo7_acceso_admin")
    if "admin" in driver.current_url:
        print("Flujo 7: Acceso con administrador - PASÓ")
    else:
        print("Flujo 7: Acceso con administrador - FALLÓ")
except Exception as e:
    print(f"Flujo 7: Acceso con administrador - FALLÓ: {e}")

# Cierro el navegador después de realizar las pruebas
driver.quit()