import javax.swing.GroupLayout;
import javax.swing.GroupLayout.Alignment;
import javax.swing.GroupLayout.ParallelGroup;
import javax.swing.GroupLayout.SequentialGroup;
import javax.swing.JComboBox;
import javax.swing.JLabel;

public class javaprint extends javax.swing.JApplet
{
  public MiImpresora miprinter;
  private javax.swing.JButton btnImprimir;
  private JComboBox cmbImpresora;
  private JLabel jLabel1;
  private javax.swing.JPanel jPanel2;
  private JLabel lblError;
  
  public javaprint() {}
  
  public void init()
  {
    try
    {
      java.awt.EventQueue.invokeAndWait(new Runnable() {
        public void run() {
          javaprint.this.initComponents();
          miprinter = new MiImpresora();
          cmbImpresora.setModel(new javax.swing.DefaultComboBoxModel(miprinter.getNames()));
          cmbImpresora.setSelectedItem(miprinter.getName());
          lblError.setText("");
        }
      });
    } catch (Exception ex) {
      ex.printStackTrace();
    }
  }
  








  private void initComponents()
  {
    jPanel2 = new javax.swing.JPanel();
    cmbImpresora = new JComboBox();
    btnImprimir = new javax.swing.JButton();
    jLabel1 = new JLabel();
    lblError = new JLabel();
    
    jPanel2.setBackground(new java.awt.Color(255, 255, 255));
    
    cmbImpresora.setModel(new javax.swing.DefaultComboBoxModel(new String[] { "Item 1", "Item 2", "Item 3", "Item 4" }));
    cmbImpresora.addItemListener(new java.awt.event.ItemListener() {
      public void itemStateChanged(java.awt.event.ItemEvent evt) {
        javaprint.this.cmbImpresoraItemStateChanged(evt);
      }
      
    });
    btnImprimir.setFont(new java.awt.Font("Tahoma", 0, 18));
    btnImprimir.setText("Imprimir");
    btnImprimir.addActionListener(new java.awt.event.ActionListener() {
      public void actionPerformed(java.awt.event.ActionEvent evt) {
        javaprint.this.btnImprimirActionPerformed(evt);
      }
      
    });
    jLabel1.setFont(new java.awt.Font("Tahoma", 0, 18));
    jLabel1.setText("Seleccione la Impresora");
    
    lblError.setFont(new java.awt.Font("Tahoma", 0, 12));
    lblError.setForeground(new java.awt.Color(255, 51, 51));
    lblError.setText("Mensaje de Error");
    
    GroupLayout jPanel2Layout = new GroupLayout(jPanel2);
    jPanel2.setLayout(jPanel2Layout);
    jPanel2Layout.setHorizontalGroup(jPanel2Layout.createParallelGroup(GroupLayout.Alignment.LEADING).addGroup(jPanel2Layout.createSequentialGroup().addContainerGap().addGroup(jPanel2Layout.createParallelGroup(GroupLayout.Alignment.LEADING).addGroup(GroupLayout.Alignment.TRAILING, jPanel2Layout.createSequentialGroup().addComponent(jLabel1).addGap(104, 104, 104)).addGroup(GroupLayout.Alignment.TRAILING, jPanel2Layout.createSequentialGroup().addComponent(cmbImpresora, 0, 380, 32767).addContainerGap()).addGroup(GroupLayout.Alignment.TRAILING, jPanel2Layout.createSequentialGroup().addComponent(btnImprimir).addGap(148, 148, 148)).addGroup(jPanel2Layout.createSequentialGroup().addComponent(lblError).addContainerGap(298, 32767)))));
    
















    jPanel2Layout.setVerticalGroup(jPanel2Layout.createParallelGroup(GroupLayout.Alignment.LEADING).addGroup(jPanel2Layout.createSequentialGroup().addContainerGap().addComponent(jLabel1).addGap(18, 18, 18).addComponent(cmbImpresora, -2, -1, -2).addGap(18, 18, 18).addComponent(btnImprimir).addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, 20, 32767).addComponent(lblError).addContainerGap()));
    












    jLabel1.getAccessibleContext().setAccessibleName("Seleccione una impresora");
    
    GroupLayout layout = new GroupLayout(getContentPane());
    getContentPane().setLayout(layout);
    layout.setHorizontalGroup(layout.createParallelGroup(GroupLayout.Alignment.LEADING).addComponent(jPanel2, GroupLayout.Alignment.TRAILING, -1, -1, 32767));
    


    layout.setVerticalGroup(layout.createParallelGroup(GroupLayout.Alignment.LEADING).addComponent(jPanel2, -1, -1, 32767));
  }
  


  private void btnImprimirActionPerformed(java.awt.event.ActionEvent evt)
  {
    lblError.setText("");
    miprinter.setPrinter(cmbImpresora.getSelectedItem().toString());
    String data = getParameter("data");
    if (data == null) {
      lblError.setText("* No se encuentra data para imprimir");
    } else {
      String param = Base64Coder.decodeString(data);
      miprinter.Imprimir(param);
    }
    btnImprimir.setEnabled(false);
  }
  
  private void cmbImpresoraItemStateChanged(java.awt.event.ItemEvent evt) {
    btnImprimir.setEnabled(true);
  }
}
