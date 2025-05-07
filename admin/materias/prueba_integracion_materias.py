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

# Defino una función para verificar si el usuario fue redirigido correctamente
def verificar_redireccion(url_esperada):
    return url_esperada in driver.current_url

# Flujo 1: Inicio de sesión para usuarios autenticados
try:
    print("Iniciando sesión como usuario autenticado...")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("admin@admin.com")  # Credenciales válidas
    driver.find_element(By.NAME, "password").send_keys("123")
    capturar_pantalla("flujo1_ingresando_datos_login")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)

    # Verifico si el usuario fue redirigido correctamente al dashboard
    WebDriverWait(driver, 10).until(lambda d: verificar_redireccion("admin"))
    capturar_pantalla("flujo1_login_exitoso")
    print("Flujo 1: Inicio de sesión - PASÓ")
except Exception as e:
    capturar_pantalla("flujo1_error")
    print(f"Flujo 1: Inicio de sesión - FALLÓ: {e}")
    driver.quit()
    exit()

# Flujo 2: Crear una nueva materia
try:
    print("Probando creación de una nueva materia...")
    driver.get("http://localhost/proyectoEscuela/admin/materias/create.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "nombre_materia")))

    # Lleno el formulario de creación
    driver.find_element(By.NAME, "nombre_materia").send_keys("Materia de Prueba")
    driver.find_element(By.NAME, "descripcion").send_keys("Descripción de prueba para la materia.")
    capturar_pantalla("flujo2_formulario_completado")

    # Envío el formulario
    driver.find_element(By.XPATH, "//button[contains(text(), 'Guardar Materia')]").click()
    WebDriverWait(driver, 10).until(lambda d: verificar_redireccion("admin/materias"))
    capturar_pantalla("flujo2_materia_creada")
    print("Flujo 2: Creación de materia - PASÓ")
except Exception as e:
    capturar_pantalla("flujo2_error")
    print(f"Flujo 2: Creación de materia - FALLÓ: {e}")

# Flujo 3: Verificar que la materia aparezca en la lista
try:
    print("Verificando que la materia aparezca en la lista...")
    driver.get("http://localhost/proyectoEscuela/admin/materias/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, "example1")))

    # Busco la materia recién creada en la tabla
    materias = driver.find_elements(By.XPATH, "//table[@id='example1']//tr")
    materia_encontrada = False
    for materia in materias:
        if "Materia de Prueba" in materia.text:
            materia_encontrada = True
            break

    capturar_pantalla("flujo3_verificar_materia_lista")
    if materia_encontrada:
        print("Flujo 3: Verificación de materia en lista - PASÓ")
    else:
        print("Flujo 3: Verificación de materia en lista - FALLÓ")
except Exception as e:
    capturar_pantalla("flujo3_error")
    print(f"Flujo 3: Verificación de materia en lista - FALLÓ: {e}")

# Flujo 4: Intento de creación por un usuario sin permisos
try:
    print("Probando creación de materia por un usuario sin permisos...")
    driver.get("http://localhost/proyectoEscuela/login/logout.php")  # Cierro sesión del administrador
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))

    # Inicio sesión con un usuario sin permisos
    driver.find_element(By.NAME, "email").send_keys("profesor@gmail.com")  # Usuario sin permisos
    driver.find_element(By.NAME, "password").send_keys("123")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    WebDriverWait(driver, 10).until(lambda d: verificar_redireccion("admin"))

    # Intento acceder a la página de creación de materias
    driver.get("http://localhost/proyectoEscuela/admin/materias/create.php")
    capturar_pantalla("flujo4_acceso_denegado")

    # Verifico si el acceso fue denegado
    if "403" in driver.title or "Acceso denegado" in driver.page_source:
        print("Flujo 4: Creación por usuario sin permisos - PASÓ")
    elif "admin/materias" in driver.current_url:
        print("Flujo 4: Creación por usuario sin permisos - FALLÓ: El usuario fue redirigido a la lista de materias.")
    else:
        print("Flujo 4: Creación por usuario sin permisos - FALLÓ: No se detectó un mensaje de error claro.")
except Exception as e:
    capturar_pantalla("flujo4_error")
    print(f"Flujo 4: Creación por usuario sin permisos - FALLÓ: {e}")

# Cierro el navegador después de realizar las pruebas
driver.quit()