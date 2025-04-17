<template>
  <div class="module">
    <div class="module-head">
      <h3>
        Personals - 
        <button @click="toggleAddEmployeeForm">Create New</button>
      </h3>
      <p><strong>Tổng nhân viên:</strong> {{ stats.totalEmployees }}</p>
      <p><strong>Tổng lương:</strong> {{ formatCurrency(stats.totalPayRate) }}</p>
    </div>

    <div class="module-body table">
      <table cellpadding="0" cellspacing="0" border="0"
             class="datatable-1 table table-bordered table-striped display" width="100%">
        <thead>
          <tr>
            <th>Full Name</th>
            <th>City</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Gender</th>
            <th>Shareholder</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in mergedData" :key="index">
            <td>{{ item.fullName }}</td>
            <td>{{ item.city }}</td>
            <td>{{ item.email }}</td>
            <td>{{ item.phoneNumber }}</td>
            <td>{{ item.gender }}</td>
            <td>{{ item.shareholder }}</td>
            <td>
              <button @click="editEmployee(item)">Edit</button>
              <button @click="deleteEmployee(item)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Form thêm nhân viên -->
      <div v-if="showAddEmployeeForm" class="form">
        <h3>📝 Nhập thông tin nhân viên</h3>
        <input v-model="newEmployee.fullName" placeholder="Họ tên" />
        <input v-model="newEmployee.city" placeholder="Thành phố" />
        <input v-model="newEmployee.email" placeholder="Email" />
        <input v-model="newEmployee.phoneNumber" placeholder="SĐT" />
        <select v-model="newEmployee.gender">
          <option disabled value="">Chọn giới tính</option>
          <option>Nam</option>
          <option>Nữ</option>
        </select>
        <select v-model="newEmployee.shareholder">
          <option value="Yes">Cổ đông</option>
          <option value="No">Không</option>
        </select>
        <button @click="addEmployee">✅ Gửi</button>
        <button @click="toggleAddEmployeeForm">❌ Hủy</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      connection: null,
      mergedData: [],
      stats: {
        totalEmployees: 0,
        totalPayRate: 0
      },
      showAddEmployeeForm: false,
      newEmployee: {
        fullName: '',
        city: '',
        email: '',
        phoneNumber: '',
        gender: '',
        shareholder: 'No',
      }
    };
  },
  mounted() {
    this.initializeWebSocket();
  },
  methods: {
    initializeWebSocket() {
      this.connection = new WebSocket('ws://localhost:8081');

      this.connection.onopen = () => {
        console.log('WebSocket connection established');
      };

      this.connection.onmessage = (event) => {
        try {
          const data = JSON.parse(event.data);
          if (data.merged_data) {
            this.mergedData = data.merged_data;
            this.stats.totalEmployees = data.total_employees || 0;
            this.stats.totalPayRate = data.total_pay_rate || 0;
          } else if (data.status === 'received') {
            alert(data.message);
          }
        } catch (error) {
          console.error('Lỗi khi xử lý dữ liệu:', error);
        }
      };

      this.connection.onclose = () => {
        console.log('WebSocket connection closed');
        setTimeout(() => this.initializeWebSocket(), 5000);
      };

      this.connection.onerror = (error) => {
        console.error('WebSocket error:', error);
      };
    },

    toggleAddEmployeeForm() {
      this.showAddEmployeeForm = !this.showAddEmployeeForm;
      if (!this.showAddEmployeeForm) {
        this.resetForm();
      }
    },

    resetForm() {
      this.newEmployee = {
        fullName: '',
        city: '',
        email: '',
        phoneNumber: '',
        gender: '',
        shareholder: 'No',
      };
    },

    addEmployee() {
      if (this.connection && this.connection.readyState === WebSocket.OPEN) {
        this.connection.send(JSON.stringify({
          type: 'addEmployee',
          data: this.newEmployee
        }));
        this.toggleAddEmployeeForm();
      } else {
        alert('Kết nối WebSocket không khả dụng.');
      }
    },

    editEmployee(employee) {
      alert('Chỉnh sửa thông tin: ' + employee.fullName);
    },

    deleteEmployee(employee) {
      alert('Xóa nhân viên: ' + employee.fullName);
    },

    formatCurrency(value) {
      return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
      }).format(value);
    }
  }
};
</script>
