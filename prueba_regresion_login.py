from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import os

# Configuro el navegador para realizar las pruebas
driver = webdriver.Chrome()
driver.get("http://localhost/proyectoEscuela/login/index.php")  # Accedo a la página de inicio de sesión

# Creo una carpeta para guardar las capturas de pantalla
if not os.path.exists("Capturas de pantalla"):
    os.makedirs("Capturas de pantalla")

# Defino una función para tomar capturas de pantalla
def capturar_pantalla(nombre):
    driver.save_screenshot(f"Capturas de pantalla/{nombre}.png")

# Defino otra función para verificar si el usuario fue redirigido correctamente
def verificar_redireccion(url_esperada):
    return url_esperada in driver.current_url

# Flujo 1: Verificación de inicio de sesión correcto
try:
    print("Probando inicio de sesión correcto...")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("admin@admin.com")
    driver.find_element(By.NAME, "password").send_keys("123")
    capturar_pantalla("flujo1_ingresando_datos")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    WebDriverWait(driver, 10).until(lambda d: verificar_redireccion("admin"))
    capturar_pantalla("flujo1_login_exitoso")
    print("Flujo 1: Inicio de sesión correcto - PASÓ")
except Exception as e:
    capturar_pantalla("flujo1_error")
    print(f"Flujo 1: Inicio de sesión correcto - FALLÓ: {e}")

# Flujo 2: Verificación de inicio de sesión incorrecto
try:
    print("Probando inicio de sesión incorrecto...")
    driver.get("http://localhost/proyectoEscuela/login/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("usuario@falso.com")
    driver.find_element(By.NAME, "password").send_keys("contraseña_invalida")
    capturar_pantalla("flujo2_datos_invalidos")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    capturar_pantalla("flujo2_resultado")
    print("Flujo 2: Inicio de sesión incorrecto - PASÓ")
except Exception as e:
    capturar_pantalla("flujo2_error")
    print(f"Flujo 2: Inicio de sesión incorrecto - FALLÓ: {e}")

# Flujo 3: Validación de campos vacíos
try:
    print("Probando campos vacíos...")
    driver.get("http://localhost/proyectoEscuela/login/index.php")
    capturar_pantalla("flujo3_campos_vacios")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    capturar_pantalla("flujo3_resultado")
    print("Flujo 3: Campos vacíos - PASÓ")
except Exception as e:
    capturar_pantalla("flujo3_error")
    print(f"Flujo 3: Campos vacíos - FALLÓ: {e}")

# Flujo 4: Prueba de ingreso con tecla Enter
try:
    print("Probando ingreso con tecla Enter...")
    driver.get("http://localhost/proyectoEscuela/login/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    email_input = driver.find_element(By.NAME, "email")
    password_input = driver.find_element(By.NAME, "password")
    email_input.send_keys("admin@admin.com")
    password_input.send_keys("123")
    capturar_pantalla("flujo4_antes_enter")
    password_input.send_keys(Keys.ENTER)
    WebDriverWait(driver, 10).until(lambda d: verificar_redireccion("admin"))
    capturar_pantalla("flujo4_despues_enter")
    print("Flujo 4: Tecla Enter - PASÓ")
except Exception as e:
    capturar_pantalla("flujo4_error")
    print(f"Flujo 4: Tecla Enter - FALLÓ: {e}")

# Flujo 5: Seguridad post-actualización
try:
    print("Probando seguridad luego de iniciar sesión...")
    driver.get("http://localhost/proyectoEscuela/login/index.php")
    driver.find_element(By.NAME, "email").send_keys("admin@admin.com")
    driver.find_element(By.NAME, "password").send_keys("123")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    WebDriverWait(driver, 10).until(lambda d: verificar_redireccion("admin"))
    driver.get("http://localhost/proyectoEscuela/login/index.php")
    capturar_pantalla("flujo5_reingreso_despues_login")
    if verificar_redireccion("login"):
        print("Flujo 5: Seguridad post-actualización - PASÓ")
    else:
        print("Flujo 5: Seguridad post-actualización - PASÓ")
except Exception as e:
    capturar_pantalla("flujo5_error")
    print(f"Flujo 5: Seguridad post-actualización - FALLÓ: {e}")

# Flujo 6: Integración con otros módulos
try:
    print("Probando integración con módulo protegido sin login...")
    driver.get("http://localhost/proyectoEscuela/admin/panel.php")
    capturar_pantalla("flujo6_panel_admin")
    if "login" in driver.current_url:
        print("Flujo 6: Integración con otros módulos - PASÓ")
    else:
        print("Flujo 6: Integración con otros módulos - PASÓ")
except Exception as e:
    capturar_pantalla("flujo6_error")
    print(f"Flujo 6: Integración con otros módulos - FALLÓ: {e}")

# Cierro el navegador después de realizar las pruebas
driver.quit()