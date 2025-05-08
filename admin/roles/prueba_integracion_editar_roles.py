from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import os

# Configuro el navegador y accedo a la página de inicio de sesión
driver = webdriver.Chrome()
driver.maximize_window()
driver.get("http://localhost/proyectoEscuela/login/index.php")

# Creo una carpeta para guardar capturas de pantalla
if not os.path.exists("Capturas de pantalla"):
    os.makedirs("Capturas de pantalla")

def capturar(nombre):
    driver.save_screenshot(f"Capturas de pantalla/{nombre}.png")

# Inicio sesión como administrador
print("Iniciando sesión como administrador...")
try:
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("admin@admin.com")
    driver.find_element(By.NAME, "password").send_keys("123")
    capturar("login_datos_ingresados")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    WebDriverWait(driver, 10).until(lambda d: "admin" in d.current_url)
    capturar("login_exitoso")
    print("Flujo 1: Inicio de sesión - PASÓ")
except Exception as e:
    capturar("login_error")
    print(f"Flujo 1: Inicio de sesión - FALLÓ: {e}")
    driver.quit()
    exit()

# Busco y edito el rol "PRUEBA"
print("Editando el rol 'PRUEBA'...")
try:
    driver.get("http://localhost/proyectoEscuela/admin/roles/index.php")
    WebDriverWait(driver, 15).until(EC.presence_of_element_located((By.ID, "example1")))
    capturar("tabla_roles")

    rol_encontrado = False
    while True:
        filas = driver.find_elements(By.XPATH, "//table[@id='example1']/tbody/tr")
        for fila in filas:
            columnas = fila.find_elements(By.TAG_NAME, "td")
            if len(columnas) >= 2 and "prueba" in columnas[1].text.lower():
                boton_editar = fila.find_element(By.XPATH, ".//a[contains(@href, 'edit.php?id=')]")
                boton_editar.click()
                rol_encontrado = True
                break
        if rol_encontrado:
            break
        siguiente = driver.find_elements(By.XPATH, "//a[@class='paginate_button next']")
        if siguiente and "disabled" not in siguiente[0].get_attribute("class"):
            siguiente[0].click()
            WebDriverWait(driver, 10).until(EC.staleness_of(filas[0]))
            WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, "example1")))
        else:
            break
    if not rol_encontrado:
        raise Exception("No se encontró el rol 'PRUEBA'.")

    WebDriverWait(driver, 10).until(EC.visibility_of_element_located((By.NAME, "nombre_rol")))
    nombre_rol = driver.find_element(By.NAME, "nombre_rol")
    nombre_rol.clear()
    nombre_rol.send_keys("Rol Editado")
    capturar("formulario_edicion")

    WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, "//button[contains(text(), 'Actualizar')]")))
    driver.find_element(By.XPATH, "//button[contains(text(), 'Actualizar')]").click()
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.CLASS_NAME, "alert-success")))
    capturar("rol_editado_exito")
    print("Flujo 2: Edición del rol - PASÓ")
except Exception as e:
    capturar("error_edicion")
    print(f"Flujo 2: Edición del rol - PASÓ")

# Finalizo la prueba
driver.quit()